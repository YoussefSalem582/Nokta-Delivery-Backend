<?php

namespace App\Http\Requests\Ride;

use Illuminate\Foundation\Http\FormRequest;

class UpdateRideStatusRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'status' => 'required|string|in:ACCEPTED,DRIVER_ARRIVING,IN_PROGRESS,COMPLETED,CANCELLED',
        ];
    }
}
