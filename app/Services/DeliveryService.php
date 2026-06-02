<?php

namespace App\Services;

use App\Models\Delivery;
use App\Models\DeliveryEvent;
use Illuminate\Support\Facades\DB;

class DeliveryService
{
    /**
     * Map Prisma DB status to Flutter frontend string
     */
    const STATUS_MAP = [
        'PENDING' => 'pending',
        'ACCEPTED' => 'accepted',
        'COURIER_ARRIVED' => 'courierArrived',
        'IN_TRANSIT' => 'inTransit',
        'DELIVERED' => 'delivered',
        'CANCELLED' => 'cancelled',
    ];

    /**
     * Get active delivery for user
     */
    public function getActiveDelivery(string $userId, string $role): ?Delivery
    {
        $query = Delivery::whereNotIn('status', ['DELIVERED', 'CANCELLED']);

        if ($role === 'RIDER') {
            $query->where('sender_id', $userId);
        } elseif ($role === 'COURIER') {
            $query->where('courier_id', $userId);
        }

        return $query->latest()->first();
    }

    /**
     * Create a new delivery order
     */
    public function createDelivery(string $senderId, array $data): Delivery
    {
        return DB::transaction(function () use ($senderId, $data) {
            $distanceKm = $data['distanceKm'] ?? 5.0; // Default or calculated
            $fare = $data['fare'] ?? round(20 + ($distanceKm * 6), 2); // Delivery pricing formula

            $delivery = Delivery::create([
                'sender_id' => $senderId,
                'package_size' => $data['packageSize'] ?? 'MEDIUM',
                'package_weight' => $data['packageWeight'] ?? null,
                'special_instructions' => $data['specialInstructions'] ?? null,
                'pickup_address' => $data['pickupAddress'],
                'dropoff_address' => $data['dropoffAddress'],
                'pickup_lat' => $data['pickupLat'],
                'pickup_lng' => $data['pickupLng'],
                'dropoff_lat' => $data['dropoffLat'],
                'dropoff_lng' => $data['dropoffLng'],
                'status' => 'PENDING',
                'fare' => $fare,
                'distance_km' => $distanceKm,
            ]);

            DeliveryEvent::create([
                'delivery_id' => $delivery->id,
                'status' => 'PENDING',
            ]);

            return $delivery;
        });
    }

    /**
     * Update delivery status
     */
    public function updateStatus(Delivery $delivery, string $newStatus, ?string $courierId = null): Delivery
    {
        return DB::transaction(function () use ($delivery, $newStatus, $courierId) {
            if ($newStatus === 'ACCEPTED' && $courierId) {
                $delivery->courier_id = $courierId;
            }

            $delivery->status = $newStatus;
            $delivery->save();

            DeliveryEvent::create([
                'delivery_id' => $delivery->id,
                'status' => $newStatus,
            ]);

            // Broadcast status update
            event(new \App\Events\DeliveryStatusUpdated($delivery));

            return $delivery;
        });
    }

    /**
     * Helper to format delivery to Flutter's expected JSON format
     */
    public function toDeliveryJson(Delivery $delivery): array
    {
        return [
            'id' => $delivery->id,
            'packageSize' => $delivery->package_size,
            'packageWeight' => (float) $delivery->package_weight,
            'specialInstructions' => $delivery->special_instructions,
            'pickupAddress' => $delivery->pickup_address,
            'dropoffAddress' => $delivery->dropoff_address,
            'pickupLat' => (float) $delivery->pickup_lat,
            'pickupLng' => (float) $delivery->pickup_lng,
            'dropoffLat' => (float) $delivery->dropoff_lat,
            'dropoffLng' => (float) $delivery->dropoff_lng,
            'status' => self::STATUS_MAP[$delivery->status] ?? 'pending',
            'senderId' => $delivery->sender_id,
            'courierId' => $delivery->courier_id,
            'fare' => (float) $delivery->fare,
            'distanceKm' => (float) $delivery->distance_km,
            'createdAt' => $delivery->created_at?->toIso8601String(),
            'updatedAt' => $delivery->updated_at?->toIso8601String(),
        ];
    }
}
