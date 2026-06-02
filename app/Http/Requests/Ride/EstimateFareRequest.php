<?php

namespace App\Http\Requests\Ride;

use Illuminate\Foundation\Http\FormRequest;

class EstimateFareRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'distanceKm' => 'required|numeric|min:0',
            'rideTierKey' => 'nullable|string',
        ];
    }
}
