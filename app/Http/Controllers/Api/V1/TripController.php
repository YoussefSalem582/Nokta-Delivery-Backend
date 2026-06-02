<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\Ride\EstimateFareRequest;
use App\Http\Requests\Ride\RequestRideRequest;
use App\Http\Requests\Ride\UpdateRideStatusRequest;
use App\Models\Ride;
use App\Services\RideService;
use App\Traits\ApiResponse;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class TripController extends Controller
{
    use ApiResponse;

    public function __construct(protected RideService $rideService)
    {
    }

    /**
     * Get a list of all trips for the authenticated user
     */
    public function index(Request $request): JsonResponse
    {
        $user = $request->user();
        $query = Ride::query();

        if ($user->role === 'RIDER') {
            $query->where('rider_id', $user->id);
        } elseif ($user->role === 'DRIVER') {
            $query->where('driver_id', $user->id);
        }

        $trips = $query->latest()->get()->map(fn ($ride) => $this->rideService->toTripJson($ride));

        return $this->buildResponse('trips.list.success', $trips);
    }

    /**
     * Get the currently active trip
     */
    public function active(Request $request): JsonResponse
    {
        $user = $request->user();
        $trip = $this->rideService->getActiveTrip($user->id, $user->role);

        if (! $trip) {
            return $this->buildErrorResponse('trips.active.not_found', null, 404);
        }

        return $this->buildResponse('trips.active.success', $this->rideService->toTripJson($trip));
    }

    /**
     * Get details of a specific trip
     */
    public function show(string $id, Request $request): JsonResponse
    {
        $trip = Ride::find($id);

        if (! $trip) {
            return $this->buildErrorResponse('trips.not_found', null, 404);
        }

        $user = $request->user();
        if ($user->role === 'RIDER' && $trip->rider_id !== $user->id) {
            return $this->buildErrorResponse('auth.forbidden', null, 403);
        }
        if ($user->role === 'DRIVER' && $trip->driver_id !== $user->id) {
            return $this->buildErrorResponse('auth.forbidden', null, 403);
        }

        return $this->buildResponse('trips.fetch.success', $this->rideService->toTripJson($trip));
    }

    /**
     * Estimate fare for a ride
     */
    public function estimateFare(EstimateFareRequest $request): JsonResponse
    {
        $fare = $this->rideService->estimateFare($request->distanceKm, $request->rideTierKey);

        return $this->buildResponse('rides.estimate.success', [
            'estimatedFare' => $fare,
            'currency' => 'EGP'
        ]);
    }

    /**
     * Request a new ride
     */
    public function requestRide(RequestRideRequest $request): JsonResponse
    {
        $ride = $this->rideService->requestRide($request->user()->id, $request->validated());

        return $this->buildResponse('rides.request.success', $this->rideService->toTripJson($ride), 201);
    }

    /**
     * Update the status of an existing ride
     */
    public function updateStatus(string $id, UpdateRideStatusRequest $request): JsonResponse
    {
        $ride = Ride::find($id);

        if (! $ride) {
            return $this->buildErrorResponse('trips.not_found', null, 404);
        }

        $user = $request->user();
        $newStatus = $request->status;

        // Permissions logic
        if ($user->role === 'RIDER' && $ride->rider_id !== $user->id) {
            return $this->buildErrorResponse('auth.forbidden', null, 403);
        }

        $driverId = null;
        if ($user->role === 'DRIVER') {
            if ($newStatus === 'ACCEPTED') {
                $driverId = $user->id;
            } elseif ($ride->driver_id !== $user->id) {
                return $this->buildErrorResponse('auth.forbidden', null, 403);
            }
        }

        $updatedRide = $this->rideService->updateStatus($ride, $newStatus, $driverId);

        return $this->buildResponse('rides.status_updated.success', $this->rideService->toTripJson($updatedRide));
    }
}
