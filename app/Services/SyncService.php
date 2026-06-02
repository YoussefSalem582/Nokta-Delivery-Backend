<?php

namespace App\Services;

use App\Models\Delivery;
use App\Models\Ride;
use App\Models\SyncRequest;
use Exception;
use Illuminate\Support\Facades\Log;

class SyncService
{
    public function __construct(
        protected RideService $rideService,
        protected DeliveryService $deliveryService
    ) {
    }

    /**
     * Process a batch of sync actions from the client.
     */
    public function processBatch(string $userId, array $actions): array
    {
        $results = [];

        foreach ($actions as $action) {
            $results[] = $this->processAction($userId, $action);
        }

        return $results;
    }

    /**
     * Reconcile client state after reconnection.
     */
    public function reconcile(string $userId): array
    {
        $activeRide = Ride::where('rider_id', $userId)
            ->whereNotIn('status', ['COMPLETED', 'CANCELLED'])
            ->first();

        if (! $activeRide) {
            // Also check driver active ride
            $activeRide = Ride::where('driver_id', $userId)
                ->whereNotIn('status', ['COMPLETED', 'CANCELLED'])
                ->first();
        }

        $pendingSync = SyncRequest::where('user_id', $userId)
            ->where('status', 'PENDING')
            ->orderBy('created_at', 'asc')
            ->get();

        return [
            'activeRide' => $activeRide ? $this->rideService->toRideJson($activeRide) : null,
            'pendingSyncCount' => $pendingSync->count(),
            'pendingActions' => $pendingSync->map(fn($s) => [
                'clientActionId' => $s->client_action_id,
                'actionType' => $s->action_type,
                'createdAt' => $s->created_at->toIso8601String(),
            ])->toArray(),
        ];
    }

    protected function processAction(string $userId, array $action): array
    {
        $clientActionId = $action['clientActionId'] ?? null;
        if (! $clientActionId) {
            return ['status' => 'failed', 'error' => 'Missing clientActionId'];
        }

        // Check if already processed
        $existing = SyncRequest::where('user_id', $userId)
            ->where('client_action_id', $clientActionId)
            ->first();

        if ($existing && $existing->status === 'PROCESSED') {
            return [
                'clientActionId' => $clientActionId,
                'status' => 'duplicate',
                'response' => json_decode($existing->response, true),
            ];
        }

        if (! $existing) {
            $existing = SyncRequest::create([
                'user_id' => $userId,
                'client_action_id' => $clientActionId,
                'action_type' => $action['actionType'] ?? 'unknown',
                'payload' => json_encode($action['payload'] ?? []),
                'status' => 'PENDING',
            ]);
        }

        try {
            $response = $this->dispatch($userId, $action);
            
            $existing->update([
                'status' => 'PROCESSED',
                'response' => json_encode($response),
                'processed_at' => now(),
            ]);

            return ['clientActionId' => $clientActionId, 'status' => 'processed', 'response' => $response];
        } catch (Exception $e) {
            Log::error('Sync process failed: ' . $e->getMessage());
            
            $existing->update([
                'status' => 'FAILED',
                'response' => json_encode(['error' => $e->getMessage()]),
            ]);
            
            return ['clientActionId' => $clientActionId, 'status' => 'failed', 'error' => $e->getMessage()];
        }
    }

    protected function dispatch(string $userId, array $action): array
    {
        $actionType = $action['actionType'] ?? '';
        $payload = $action['payload'] ?? [];

        switch ($actionType) {
            case 'ride.request':
                $ride = $this->rideService->requestRide($userId, $payload);
                return $this->rideService->toRideJson($ride);
                
            case 'delivery.create':
                $delivery = $this->deliveryService->createDelivery($userId, $payload);
                return $this->deliveryService->toDeliveryJson($delivery);
                
            default:
                throw new Exception("Unsupported action type: {$actionType}");
        }
    }
}
