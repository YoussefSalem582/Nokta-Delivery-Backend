<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\Delivery\CreateDeliveryRequest;
use App\Http\Requests\Delivery\UpdateDeliveryStatusRequest;
use App\Models\Delivery;
use App\Services\DeliveryService;
use App\Traits\ApiResponse;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class DeliveryController extends Controller
{
    use ApiResponse;

    public function __construct(protected DeliveryService $deliveryService)
    {
    }

    /**
     * Get a list of all deliveries for the authenticated user
     */
    public function index(Request $request): JsonResponse
    {
        $user = $request->user();
        $query = Delivery::query();

        if ($user->role === 'RIDER') {
            $query->where('sender_id', $user->id);
        } elseif ($user->role === 'COURIER') {
            $query->where('courier_id', $user->id);
        }

        $deliveries = $query->latest()->get()->map(fn ($d) => $this->deliveryService->toDeliveryJson($d));

        return $this->buildResponse('deliveries.list.success', $deliveries);
    }

    /**
     * Get the currently active delivery
     */
    public function active(Request $request): JsonResponse
    {
        $user = $request->user();
        $delivery = $this->deliveryService->getActiveDelivery($user->id, $user->role);

        if (! $delivery) {
            return $this->buildErrorResponse('deliveries.active.not_found', null, 404);
        }

        return $this->buildResponse('deliveries.active.success', $this->deliveryService->toDeliveryJson($delivery));
    }

    /**
     * Get details of a specific delivery
     */
    public function show(string $id, Request $request): JsonResponse
    {
        $delivery = Delivery::find($id);

        if (! $delivery) {
            return $this->buildErrorResponse('deliveries.not_found', null, 404);
        }

        $user = $request->user();
        if ($user->role === 'RIDER' && $delivery->sender_id !== $user->id) {
            return $this->buildErrorResponse('auth.forbidden', null, 403);
        }
        if ($user->role === 'COURIER' && $delivery->courier_id !== $user->id) {
            return $this->buildErrorResponse('auth.forbidden', null, 403);
        }

        return $this->buildResponse('deliveries.fetch.success', $this->deliveryService->toDeliveryJson($delivery));
    }

    /**
     * Request a new delivery
     */
    public function store(CreateDeliveryRequest $request): JsonResponse
    {
        $delivery = $this->deliveryService->createDelivery($request->user()->id, $request->validated());

        return $this->buildResponse('deliveries.create.success', $this->deliveryService->toDeliveryJson($delivery), 201);
    }

    /**
     * Update the status of an existing delivery
     */
    public function updateStatus(string $id, UpdateDeliveryStatusRequest $request): JsonResponse
    {
        $delivery = Delivery::find($id);

        if (! $delivery) {
            return $this->buildErrorResponse('deliveries.not_found', null, 404);
        }

        $user = $request->user();
        $newStatus = $request->status;

        // Permissions logic
        if ($user->role === 'RIDER' && $delivery->sender_id !== $user->id) {
            return $this->buildErrorResponse('auth.forbidden', null, 403);
        }

        $courierId = null;
        if ($user->role === 'COURIER') {
            if ($newStatus === 'ACCEPTED') {
                $courierId = $user->id;
            } elseif ($delivery->courier_id !== $user->id) {
                return $this->buildErrorResponse('auth.forbidden', null, 403);
            }
        }

        $updatedDelivery = $this->deliveryService->updateStatus($delivery, $newStatus, $courierId);

        return $this->buildResponse('deliveries.status_updated.success', $this->deliveryService->toDeliveryJson($updatedDelivery));
    }

    /**
     * Get tracking info for a delivery
     */
    public function tracking(string $id, Request $request): JsonResponse
    {
        $delivery = Delivery::with(['courier', 'locations'])->find($id);

        if (! $delivery) {
            return $this->buildErrorResponse('deliveries.not_found', null, 404);
        }

        // Just returning the delivery payload for now, as it contains status and location history
        return $this->buildResponse('deliveries.tracking.success', $this->deliveryService->toDeliveryJson($delivery));
    }
}
