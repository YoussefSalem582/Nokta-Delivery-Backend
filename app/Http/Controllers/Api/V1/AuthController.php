<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use App\Http\Requests\Auth\RegisterRequest;
use App\Http\Requests\Auth\DeviceTokenRequest;
use App\Models\DeviceToken;
use App\Services\AuthService;
use App\Traits\ApiResponse;
use Illuminate\Http\JsonResponse;
use OpenApi\Attributes as OA;
use Illuminate\Http\Request;

/**
 * Handles authentication for the API
 */
class AuthController extends Controller
{
    use ApiResponse;

    public function __construct(protected AuthService $authService)
    {
    }

    /**
     * Register a new user
     */
    public function register(RegisterRequest $request): JsonResponse
    {
        $user = $this->authService->register($request->validated());
        $tokens = $this->authService->generateTokens($user);

        return $this->buildResponse('auth.register.success', [
            'user' => $user,
            'tokens' => $tokens,
        ]);
    }

    /**
     * Login existing user
     */
    #[OA\Post(
        path: '/api/v1/auth/login',
        summary: 'Login user',
        tags: ['Auth'],
        responses: [
            new OA\Response(response: 200, description: 'Successful login')
        ]
    )]
    public function login(LoginRequest $request): JsonResponse
    {
        $user = $this->authService->login($request->email, $request->password);
        $tokens = $this->authService->generateTokens($user);

        return $this->buildResponse('auth.login.success', [
            'user' => $user,
            'tokens' => $tokens,
        ]);
    }

    /**
     * Request a password reset link
     */
    public function forgotPassword(Request $request): JsonResponse
    {
        $request->validate([
            'email' => 'required|email|exists:users,email',
        ]);
        
        // Mock sending password reset link
        return $this->buildResponse('auth.forgot_password.success', [
            'message' => 'Password reset link sent successfully.',
        ]);
    }

    /**
     * Register a new driver
     */
    public function driverRegister(RegisterRequest $request): JsonResponse
    {
        $data = $request->validated();
        $data['role'] = 'DRIVER';

        $user = $this->authService->register($data);
        $tokens = $this->authService->generateTokens($user);

        return $this->buildResponse('auth.register.success', [
            'user' => $user,
            'tokens' => $tokens,
        ]);
    }

    /**
     * Refresh access token
     */
    public function refresh(Request $request): JsonResponse
    {
        // Require a valid refresh token
        $request->validate([
            'refresh_token' => 'required|string',
        ]);

        // Note: In a robust Sanctum refresh setup, we'd verify the refresh token from DB.
        // For simplicity, we assume the user is passing it. Since Sanctum tokens are hashed,
        // we normally use an ID|Hash string.
        // If we trust the Bearer token as the refresh token (middleware 'auth:sanctum'),
        // we can check if it has the 'refresh' ability.
        $user = $request->user();

        if (! $user || ! $user->currentAccessToken()->can('refresh')) {
            return $this->buildErrorResponse('auth.invalid_token', null, 401);
        }

        // Revoke the old refresh token
        $user->currentAccessToken()->delete();

        $tokens = $this->authService->generateTokens($user);

        return $this->buildResponse('auth.refresh.success', [
            'tokens' => $tokens,
        ]);
    }

    /**
     * Logout user and revoke tokens
     */
    public function logout(Request $request): JsonResponse
    {
        $request->user()->currentAccessToken()->delete();

        return $this->buildResponse('auth.logout.success');
    }

    /**
     * Register a device token for push notifications
     */
    public function deviceToken(DeviceTokenRequest $request): JsonResponse
    {
        DeviceToken::updateOrCreate(
            ['token' => $request->token],
            [
                'user_id' => $request->user()->id,
                'platform' => $request->platform,
            ]
        );

        return $this->buildResponse('auth.device_token.success');
    }
}
