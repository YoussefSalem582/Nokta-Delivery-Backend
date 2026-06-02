<?php

namespace App\Services;

use App\Models\Ride;
use App\Models\RideEvent;
use Illuminate\Support\Facades\DB;
use InvalidArgumentException;

class RideService
{
    /**
     * Map Prisma DB status to Flutter frontend string
     */
    const STATUS_MAP = [
        'REQUESTED' => 'requested',
        'ACCEPTED' => 'accepted',
        'DRIVER_ARRIVING' => 'driverArrived',
        'IN_PROGRESS' => 'inProgress',
        'COMPLETED' => 'completed',
        'CANCELLED' => 'cancelled',
    ];

    /**
     * Get active trip for user
     */
    public function getActiveTrip(string $userId, string $role): ?Ride
    {
        $query = Ride::whereNotIn('status', ['COMPLETED', 'CANCELLED']);

        if ($role === 'RIDER') {
            $query->where('rider_id', $userId);
        } else {
            $query->where('driver_id', $userId);
        }

        return $query->latest()->first();
    }

    /**
     * Estimate fare
     */
    public function estimateFare(float $distanceKm, ?string $tier = 'default'): float
    {
        $baseFare = 15;
        $perKm = 8;
        $multiplier = match ($tier) {
            'premium' => 1.4,
            'comfort' => 1.2,
            default => 1.0,
        };

        return round(($baseFare + ($distanceKm * $perKm)) * $multiplier, 2);
    }

    /**
     * Request a new ride
     */
    public function requestRide(string $riderId, array $data): Ride
    {
        return DB::transaction(function () use ($riderId, $data) {
            // Distance approximation if not provided by client
            $distanceKm = $data['distanceKm'] ?? $this->approximateDistance(
                $data['pickupLat'], $data['pickupLng'],
                $data['dropoffLat'], $data['dropoffLng']
            );

            $etaMinutes = $data['etaMinutes'] ?? max(5, round($distanceKm * 3));
            $fare = $data['fare'] ?? $this->estimateFare($distanceKm, $data['rideTierKey'] ?? 'default');

            $ride = Ride::create([
                'rider_id' => $riderId,
                'pickup_address' => $data['pickupAddress'],
                'dropoff_address' => $data['dropoffAddress'],
                'pickup_lat' => $data['pickupLat'],
                'pickup_lng' => $data['pickupLng'],
                'dropoff_lat' => $data['dropoffLat'],
                'dropoff_lng' => $data['dropoffLng'],
                'status' => 'REQUESTED',
                'fare' => $fare,
                'distance_km' => $distanceKm,
                'eta_minutes' => $etaMinutes,
                'payment_method_key' => $data['paymentMethodKey'] ?? null,
                'ride_tier_key' => $data['rideTierKey'] ?? null,
                'idempotency_key' => $data['idempotencyKey'] ?? null,
            ]);

            RideEvent::create([
                'ride_id' => $ride->id,
                'status' => 'REQUESTED',
            ]);

            // NOTE: In Phase 6 we will dispatch a job to find a driver or broadcast to nearby drivers

            return $ride;
        });
    }

    /**
     * Update ride status
     */
    public function updateStatus(Ride $ride, string $newStatus, ?string $driverId = null): Ride
    {
        return DB::transaction(function () use ($ride, $newStatus, $driverId) {
            if ($newStatus === 'ACCEPTED' && $driverId) {
                $ride->driver_id = $driverId;
            }

            $ride->status = $newStatus;
            $ride->save();

            RideEvent::create([
                'ride_id' => $ride->id,
                'status' => $newStatus,
            ]);

            // NOTE: In Phase 5/6 we broadcast this change to the rider via WebSockets/Push

            return $ride;
        });
    }

    /**
     * Helper to format ride to Flutter's expected JSON format
     */
    public function toTripJson(Ride $ride): array
    {
        return [
            'id' => $ride->id,
            'pickupAddress' => $ride->pickup_address,
            'dropoffAddress' => $ride->dropoff_address,
            'pickupLat' => (float) $ride->pickup_lat,
            'pickupLng' => (float) $ride->pickup_lng,
            'dropoffLat' => (float) $ride->dropoff_lat,
            'dropoffLng' => (float) $ride->dropoff_lng,
            'status' => self::STATUS_MAP[$ride->status] ?? 'requested',
            'riderId' => $ride->rider_id,
            'driverId' => $ride->driver_id,
            'fare' => (float) $ride->fare,
            'distanceKm' => (float) $ride->distance_km,
            'etaMinutes' => $ride->eta_minutes,
            'paymentMethodKey' => $ride->payment_method_key,
            'rideTierKey' => $ride->ride_tier_key,
            'driverLat' => $ride->driver_lat ? (float) $ride->driver_lat : null,
            'driverLng' => $ride->driver_lng ? (float) $ride->driver_lng : null,
            'createdAt' => $ride->created_at?->toIso8601String(),
            'updatedAt' => $ride->updated_at?->toIso8601String(),
        ];
    }

    /**
     * Calculate approximate distance using Haversine formula (km)
     */
    private function approximateDistance($lat1, $lon1, $lat2, $lon2): float
    {
        $earthRadius = 6371;

        $dLat = deg2rad($lat2 - $lat1);
        $dLon = deg2rad($lon2 - $lon1);

        $a = sin($dLat / 2) * sin($dLat / 2) +
             cos(deg2rad($lat1)) * cos(deg2rad($lat2)) *
             sin($dLon / 2) * sin($dLon / 2);

        $c = 2 * atan2(sqrt($a), sqrt(1 - $a));
        return round($earthRadius * $c, 2);
    }
}
