<?php

namespace App\Http\Requests\Ride;

use Illuminate\Foundation\Http\FormRequest;

class RequestRideRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'pickupAddress' => 'required|string',
            'dropoffAddress' => 'required|string',
            'pickupLat' => 'required|numeric',
            'pickupLng' => 'required|numeric',
            'dropoffLat' => 'required|numeric',
            'dropoffLng' => 'required|numeric',
            'fare' => 'nullable|numeric|min:0',
            'distanceKm' => 'nullable|numeric|min:0',
            'etaMinutes' => 'nullable|integer|min:0',
            'paymentMethodKey' => 'nullable|string',
            'rideTierKey' => 'nullable|string',
            'idempotencyKey' => 'nullable|string',
        ];
    }
}
