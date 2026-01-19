<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CustomerRequest extends FormRequest
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

            // Personal
            'first_name' => 'required|string|max:100',
            'last_name'  => 'required|string|max:100',
            'dob'        => 'nullable|date',
            'zip'        => 'nullable|string|max:20',
            'mobile'     => 'required|string|max:20',
            'email'      => 'nullable|email|max:150',
            'city'       => 'required|string|max:100',
            'country'    => 'required|string|max:100',
            'permanent_address' => 'nullable|string',

            // Visitor
            'hotel_name'    => 'nullable|string|max:150',
            'room_no'       => 'nullable|string|max:50',
            'visitor_city'  => 'nullable|string|max:100',
            'visitor_phone' => 'nullable|string|max:20',
            'uae_address'   => 'nullable|string',
            'uae_city'      => 'nullable|string|max:100',

            // Passport
            'nationality'      => 'required|string|max:100',
            'passport_no'      => 'required|string|max:50',
            'passport_expiry'  => 'required|date',
            'age'              => 'required|integer|min:1',

            // Emergency
            'emergency_name'     => 'nullable|string|max:150',
            'emergency_relation' => 'nullable|string|max:100',
            'emergency_city'     => 'nullable|string|max:100',
            'emergency_phone'    => 'nullable|string|max:20',
            'emergency_address'  => 'nullable|string',

            // License
            'license_no'                  => 'nullable|string|max:50',
            'license_country'             => 'nullable|string|max:100',
            'license_expiry'              => 'nullable|date',
            'international_license_no'    => 'nullable|string|max:50',

            // Payment
            'card_type' => 'nullable|string|max:50',
            'card_expiry' => 'nullable',

            
            // 'card_expiry' => 'nullable|regex:/^(0[1-9]|1[0-2])\/\d{2}$/',
            'card_number' => 'nullable|string|max:25',


            // Image
            'image' => 'nullable|image|max:2048',
        ];
    }

}
