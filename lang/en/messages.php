<?php

return [
    'auth' => [
        'register' => [
            'success' => 'Registration successful.',
        ],
        'login' => [
            'success' => 'Login successful.',
        ],
        'refresh' => [
            'success' => 'Token refreshed successfully.',
        ],
        'logout' => [
            'success' => 'Logged out successfully.',
        ],
        'device_token' => [
            'success' => 'Device token registered successfully.',
        ],
        'invalid_credentials' => 'Invalid email or password.',
        'account_disabled' => 'Account is disabled.',
        'invalid_token' => 'Invalid or expired token.',
        'unauthorized' => 'Unauthorized.',
        'forbidden' => 'Forbidden.',
    ],
    'profile' => [
        'fetch' => [
            'success' => 'Profile retrieved successfully.',
        ],
    ],
    'trips' => [
        'list' => [
            'success' => 'Trips retrieved successfully.',
        ],
        'active' => [
            'success' => 'Active trip retrieved successfully.',
            'not_found' => 'No active trip found.',
        ],
        'fetch' => [
            'success' => 'Trip retrieved successfully.',
        ],
        'not_found' => 'Trip not found.',
    ],
    'rides' => [
        'estimate' => [
            'success' => 'Fare estimated successfully.',
        ],
        'request' => [
            'success' => 'Ride requested successfully.',
        ],
        'status_updated' => [
            'success' => 'Ride status updated successfully.',
        ],
        'offer_unavailable' => 'This ride offer is no longer available.',
        'accept' => [
            'success' => 'Ride accepted successfully.',
        ],
        'decline' => [
            'success' => 'Ride declined successfully.',
        ],
    ],
    'drivers' => [
        'list' => [
            'success' => 'Drivers retrieved successfully.',
        ],
        'offers' => [
            'success' => 'Ride offers retrieved successfully.',
        ],
    ],
    'common' => [
        'internal_error' => 'An internal server error occurred.',
    ],
];
