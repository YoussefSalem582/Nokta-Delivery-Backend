<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Services\SyncService;
use App\Traits\ApiResponse;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class SyncController extends Controller
{
    use ApiResponse;

    public function __construct(protected SyncService $syncService)
    {
    }

    /**
     * Process queued offline actions
     */
    public function syncActions(Request $request): JsonResponse
    {
        $request->validate([
            'actions' => 'required|array',
        ]);

        $results = $this->syncService->processBatch($request->user()->id, $request->actions);

        return $this->buildResponse('common.success', ['results' => $results]);
    }

    /**
     * Reconcile client state after reconnect
     */
    public function reconcile(Request $request): JsonResponse
    {
        $data = $this->syncService->reconcile($request->user()->id);

        return $this->buildResponse('common.success', $data);
    }
}
