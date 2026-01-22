<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class TourBookingRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'customer_id'=>'required|exists:customers,id',
            'tour_id'=>'required|exists:tours,id',
            'motorcycle_id'=>'nullable|exists:motorcycles,id',
            'pick_date'=>'required|date',
            'status'=>'required|in:pending,approved,cancelled',
            'group_price'=>'nullable|numeric|min:0',
            'private_price'=>'nullable|numeric|min:0',
            'passenger_price'=>'required|numeric|min:0',
            'description'=>'nullable|string',
        ];
    }
}
