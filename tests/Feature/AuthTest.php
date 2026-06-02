<?php

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

test('a user can register', function () {
    $response = $this->postJson('/api/v1/auth/register', [
        'name' => 'Test User',
        'email' => 'test@example.com',
        'password' => 'password',
        'password_confirmation' => 'password',
        'role' => 'RIDER',
        'phone' => '1234567890',
    ]);

    $response->assertStatus(201)
        ->assertJsonStructure([
            'success',
            'messageKey',
            'data' => [
                'user' => [
                    'id',
                    'name',
                    'email',
                    'role',
                ],
                'accessToken',
                'refreshToken',
            ]
        ]);

    $this->assertDatabaseHas('users', [
        'email' => 'test@example.com',
        'role' => 'RIDER',
    ]);
});

test('a user can login', function () {
    $user = User::factory()->create([
        'email' => 'login@example.com',
        'password' => bcrypt('password'),
        'role' => 'RIDER',
    ]);

    $response = $this->postJson('/api/v1/auth/login', [
        'email' => 'login@example.com',
        'password' => 'password',
    ]);

    $response->assertStatus(200)
        ->assertJsonStructure([
            'success',
            'data' => [
                'accessToken',
                'refreshToken',
            ]
        ]);
});

test('a user can fetch their profile', function () {
    $user = User::factory()->create(['role' => 'RIDER']);

    $response = $this->actingAs($user, 'sanctum')->getJson('/api/profile');

    $response->assertStatus(200)
        ->assertJsonPath('data.email', $user->email);
});
