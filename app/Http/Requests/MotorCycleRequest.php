<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class MotorCycleRequest extends FormRequest
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
            'name' => 'required|string|max:255',
            'code' => 'nullable|string|max:50',
            'slug' => [
                'required',
                'string',
                'max:255',
                Rule::unique('motorcycles', 'slug')->ignore($this->motorcycle)
            ],
            'quantity' => 'nullable|integer|min:0',
            'sort_order' => 'nullable|integer|min:0',
            'brand_id' => 'nullable|integer',
            'status' => 'required|in:featured,unfeatured',
            'visibility' => 'required|in:show,hide',
            'base_price' => 'required|numeric|min:0',
            'extra_price' => 'required|numeric|min:0',
            'description' => 'nullable|string',
            'image' => 'nullable|image|max:2048',
        ];
    }
}
