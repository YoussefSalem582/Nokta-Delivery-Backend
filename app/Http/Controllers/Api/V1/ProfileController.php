<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Traits\ApiResponse;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class ProfileController extends Controller
{
    use ApiResponse;

    /**
     * Get the current user profile.
     */
    public function show(Request $request): JsonResponse
    {
        $user = $request->user()->load(['riderProfile', 'driverProfile', 'courierProfile']);

        // Format for Flutter compatibility
        $profileData = [
            'id' => $user->id,
            'name' => $user->name,
            'email' => $user->email,
            'phone' => $user->phone,
            'role' => $user->role,
            'avatar_url' => $user->avatar_url,
            'wallet_balance' => $user->wallet_balance,
        ];

        if ($user->role === 'RIDER' && $user->riderProfile) {
            $profileData['riderProfile'] = $user->riderProfile;
        } elseif ($user->role === 'DRIVER' && $user->driverProfile) {
            $profileData['driverProfile'] = $user->driverProfile;
        } elseif ($user->role === 'COURIER' && $user->courierProfile) {
            $profileData['courierProfile'] = $user->courierProfile;
        }

        return $this->buildResponse('profile.fetch.success', $profileData);
    }
}
