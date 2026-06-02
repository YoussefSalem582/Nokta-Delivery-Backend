<?php

use Illuminate\Support\Facades\Broadcast;
use App\Models\Ride;
use App\Models\Delivery;

/*
|--------------------------------------------------------------------------
| Broadcast Channels
|--------------------------------------------------------------------------
|
| Here you may register all of the event broadcasting channels that your
| application supports. The given channel authorization callbacks are
| used to check if an authenticated user can listen to the channel.
|
*/

Broadcast::channel('App.Models.User.{id}', function ($user, $id) {
    return (int) $user->id === (int) $id;
});

// Ride Channel Authorization
Broadcast::channel('rides.{id}', function ($user, $id) {
    $ride = Ride::find($id);
    if (! $ride) return false;
    
    // Only the assigned rider and driver can listen
    return $user->id === $ride->rider_id || $user->id === $ride->driver_id;
});

// Delivery Channel Authorization
Broadcast::channel('deliveries.{id}', function ($user, $id) {
    $delivery = Delivery::find($id);
    if (! $delivery) return false;
    
    // Only the sender and courier can listen
    return $user->id === $delivery->sender_id || $user->id === $delivery->courier_id;
});
