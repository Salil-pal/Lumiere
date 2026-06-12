<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AddToCartRequest extends FormRequest
{
    /**
     * Authorize request
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Validation rules
     */
    public function rules(): array
    {
        return [
            'id' => 'required|exists:products,id',
        ];
    }

    /**
     * Custom messages
     */
    public function messages(): array
    {
        return [
            'id.required' => 'Product ID is required.',
            'id.exists'   => 'Product does not exist.',
        ];
    }
}