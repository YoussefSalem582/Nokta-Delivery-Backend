<?php

use App\Models\Ride;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

test('a rider can estimate fare', function () {
    $rider = User::factory()->create(['role' => 'RIDER']);

    $response = $this->actingAs($rider, 'sanctum')->postJson('/api/rides/estimate-fare', [
        'pickupLat' => 30.0444,
        'pickupLng' => 31.2357,
        'dropoffLat' => 30.05,
        'dropoffLng' => 31.24,
        'distanceKm' => 5.2,
        'tier' => 'ECONOMY',
    ]);

    $response->assertStatus(200)
        ->assertJsonStructure([
            'data' => [
                'tier',
                'estimatedFare',
                'currency',
                'distanceKm',
            ]
        ]);
});

test('a rider can request a ride', function () {
    $rider = User::factory()->create(['role' => 'RIDER']);

    $response = $this->actingAs($rider, 'sanctum')->postJson('/api/trips/request', [
        'pickupLat' => 30.0444,
        'pickupLng' => 31.2357,
        'dropoffLat' => 30.05,
        'dropoffLng' => 31.24,
        'pickupAddress' => 'Tahrir Square',
        'dropoffAddress' => 'Ramses Station',
        'tier' => 'ECONOMY',
        'estimatedFare' => 50,
        'distanceKm' => 5.2,
    ]);

    $response->assertStatus(201)
        ->assertJsonPath('data.status', 'REQUESTED');
        
    $this->assertDatabaseHas('rides', [
        'rider_id' => $rider->id,
        'status' => 'REQUESTED',
    ]);
});
