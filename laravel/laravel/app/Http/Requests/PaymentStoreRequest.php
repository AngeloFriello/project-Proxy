<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PaymentStoreRequest extends FormRequest
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
            'client_name' => 'required|max:255|string',
            'description' => 'required|max:600|string',
            'total_price' => 'required|max:255',
            'quantity' => 'required|max:255',
            'product_price' => 'required|max:255',
            'product_name' => 'required|max:255',
        ];
    }
}
