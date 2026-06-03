<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Delivery;
use App\Services\DeliveryService;
use App\Traits\ApiResponse;
use Illuminate\Http\JsonResponse;

class OrderController extends Controller
{
    use ApiResponse;

    public function __construct(protected DeliveryService $deliveryService)
    {
    }

    /**
     * Get a list of all orders (deliveries) for the authenticated user
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

        $orders = $query->latest()->get()->map(fn ($d) => $this->deliveryService->toDeliveryJson($d));

        return $this->buildResponse('orders.list.success', $orders);
    }
}
