<?php

namespace App\Http\Requests\Delivery;

use Illuminate\Foundation\Http\FormRequest;

class UpdateDeliveryStatusRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'status' => 'required|string|in:ACCEPTED,COURIER_ARRIVING,IN_TRANSIT,DELIVERED,CANCELLED',
        ];
    }
}
