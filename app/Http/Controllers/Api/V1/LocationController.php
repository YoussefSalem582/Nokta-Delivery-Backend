<?php

namespace App\Http\Controllers\Api\V1;

use App\Events\CourierLocationUpdated;
use App\Events\DriverLocationUpdated;
use App\Http\Controllers\Controller;
use App\Models\Delivery;
use App\Models\Ride;
use App\Traits\ApiResponse;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class LocationController extends Controller
{
    use ApiResponse;

    /**
     * Update location for an active ride (Driver)
     */
    public function updateRideLocation(string $id, Request $request): JsonResponse
    {
        $request->validate([
            'lat' => 'required|numeric',
            'lng' => 'required|numeric',
            'bearing' => 'nullable|numeric',
        ]);

        $ride = Ride::find($id);

        if (! $ride) {
            return $this->buildErrorResponse('trips.not_found', null, 404);
        }

        $user = $request->user();

        if ($ride->driver_id !== $user->id) {
            return $this->buildErrorResponse('auth.forbidden', null, 403);
        }

        // Broadcast to the rider
        event(new DriverLocationUpdated(
            $ride->id,
            $user->id,
            $request->lat,
            $request->lng,
            $request->bearing
        ));

        // Optionally, update the DB with latest location (often better kept in Redis)
        $ride->update([
            'driver_lat' => $request->lat,
            'driver_lng' => $request->lng,
        ]);

        return $this->buildResponse('common.success');
    }

    /**
     * Update location for an active delivery (Courier)
     */
    public function updateDeliveryLocation(string $id, Request $request): JsonResponse
    {
        $request->validate([
            'lat' => 'required|numeric',
            'lng' => 'required|numeric',
            'bearing' => 'nullable|numeric',
        ]);

        $delivery = Delivery::find($id);

        if (! $delivery) {
            return $this->buildErrorResponse('deliveries.not_found', null, 404);
        }

        $user = $request->user();

        if ($delivery->courier_id !== $user->id) {
            return $this->buildErrorResponse('auth.forbidden', null, 403);
        }

        // Broadcast to the sender
        event(new CourierLocationUpdated(
            $delivery->id,
            $user->id,
            $request->lat,
            $request->lng,
            $request->bearing
        ));

        return $this->buildResponse('common.success');
    }
}
