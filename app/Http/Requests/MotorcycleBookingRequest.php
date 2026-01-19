<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class MotorcycleBookingRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'customer_id' => 'required|exists:customers,id',
            'motorcycle_id' => 'required|exists:motorcycles,id',
            'status' => 'required|in:pending,confirmed,cancelled',
            'pick_date' => 'required|date',
            'drop_date' => 'required|date|after_or_equal:pick_date',
            'pick_time' => 'required',
            'drop_time' => 'required',
            'addons' => 'nullable|array',
            'description' => 'nullable|string',
        ];
        
    }
}
