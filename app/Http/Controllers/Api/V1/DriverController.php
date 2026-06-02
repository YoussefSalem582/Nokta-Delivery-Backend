<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Models\Ride;
use App\Models\Review;
use App\Services\RideService;
use App\Traits\ApiResponse;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class DriverController extends Controller
{
    use ApiResponse;

    public function __construct(protected RideService $rideService)
    {
    }

    /**
     * Get nearby drivers (Simulated for Flutter app map)
     */
    public function index(Request $request): JsonResponse
    {
        // Simulating nearby drivers for the Flutter app.
        // The Flutter app uses `lib/core/utils/driver_placement.dart` which places random drivers.
        // It expects an array of drivers with location data.
        
        $lat = $request->query('lat');
        $lng = $request->query('lng');

        // Stubbed response as Nokta MVP simulates this locally.
        $drivers = [];

        if ($lat && $lng) {
            $drivers[] = [
                'id' => 'simulated-driver-1',
                'lat' => $lat + 0.002,
                'lng' => $lng + 0.002,
                'bearing' => 90,
            ];
            $drivers[] = [
                'id' => 'simulated-driver-2',
                'lat' => $lat - 0.002,
                'lng' => $lng - 0.001,
                'bearing' => 180,
            ];
        }

        return $this->buildResponse('drivers.list.success', $drivers);
    }

    /**
     * Get ride offers for the current driver
     */
    public function offers(Request $request): JsonResponse
    {
        // In a real system, this would query a dispatch table or Redis queue.
        // For Nokta MVP, we return rides that are REQUESTED and match the driver's profile loosely.
        
        $rides = Ride::where('status', 'REQUESTED')->latest()->get()->map(fn ($ride) => $this->rideService->toTripJson($ride));

        return $this->buildResponse('drivers.offers.success', $rides);
    }

    /**
     * Accept a ride offer
     */
    public function acceptOffer(string $id, Request $request): JsonResponse
    {
        $ride = Ride::find($id);

        if (! $ride || $ride->status !== 'REQUESTED') {
            return $this->buildErrorResponse('rides.offer_unavailable', null, 400);
        }

        $driverId = $request->user()->id;
        $updatedRide = $this->rideService->updateStatus($ride, 'ACCEPTED', $driverId);

        return $this->buildResponse('rides.accept.success', $this->rideService->toTripJson($updatedRide));
    }

    /**
     * Decline a ride offer
     */
    public function declineOffer(string $id, Request $request): JsonResponse
    {
        // Declining simply ignores it for this driver. If there's an explicit dispatch table,
        // we'd mark it declined there. For MVP, just return success.
        
        return $this->buildResponse('rides.decline.success');
    }

    /**
     * Update driver availability
     */
    public function updateAvailability(Request $request): JsonResponse
    {
        $request->validate([
            'is_available' => 'required|boolean',
        ]);

        $profile = $request->user()->driverProfile;
        
        if ($profile) {
            $profile->availability = $request->is_available ? 'ONLINE' : 'OFFLINE';
            $profile->save();
        }

        return $this->buildResponse('drivers.availability.success', [
            'availability' => $profile ? $profile->availability : 'OFFLINE',
        ]);
    }

    /**
     * Get reviews for a specific driver
     */
    public function reviews(string $id, Request $request): JsonResponse
    {
        $reviews = Review::where('driver_id', $id)
            ->latest()
            ->get();

        return $this->buildResponse('drivers.reviews.success', $reviews);
    }
}
