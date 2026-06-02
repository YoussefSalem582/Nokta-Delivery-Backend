<?php

namespace App\Services;

use App\Models\User;
use App\Models\RiderProfile;
use App\Models\DriverProfile;
use App\Models\CourierProfile;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

class AuthService
{
    /**
     * Register a new user.
     * 
     * @param array $data
     * @return User
     */
    public function register(array $data): User
    {
        $role = $data['role'] ?? 'RIDER';

        // Create the user
        $user = User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'phone' => $data['phone'],
            'password' => Hash::make($data['password']),
            'role' => $role,
        ]);

        // Create the associated role profile
        if ($role === 'RIDER') {
            RiderProfile::create(['user_id' => $user->id]);
        } elseif ($role === 'DRIVER') {
            DriverProfile::create(['user_id' => $user->id]);
        } elseif ($role === 'COURIER') {
            CourierProfile::create(['user_id' => $user->id]);
        }

        return $user;
    }

    /**
     * Authenticate a user by email and password.
     * 
     * @param string $email
     * @param string $password
     * @return User
     * @throws ValidationException
     */
    public function login(string $email, string $password): User
    {
        $user = User::where('email', $email)->first();

        if (! $user || ! Hash::check($password, $user->password)) {
            throw ValidationException::withMessages([
                'email' => ['auth.invalid_credentials'],
            ]);
        }

        if (! $user->is_active) {
            throw ValidationException::withMessages([
                'email' => ['auth.account_disabled'],
            ]);
        }

        return $user;
    }

    /**
     * Generate access and refresh tokens for a user.
     * 
     * @param User $user
     * @return array
     */
    public function generateTokens(User $user): array
    {
        // Issue an access token
        $accessToken = $user->createToken('access_token', ['access'], now()->addMinutes(config('sanctum.expiration', 60 * 24 * 7)));
        
        // Issue a refresh token (optional, implemented via capabilities)
        $refreshToken = $user->createToken('refresh_token', ['refresh'], now()->addDays(30));

        return [
            'access_token' => $accessToken->plainTextToken,
            'refresh_token' => $refreshToken->plainTextToken,
        ];
    }
}
