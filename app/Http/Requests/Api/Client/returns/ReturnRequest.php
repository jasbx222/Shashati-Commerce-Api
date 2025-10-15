<?php

namespace App\Http\Requests\Api\Client\returns;

use Illuminate\Foundation\Http\FormRequest;

class ReturnRequest extends FormRequest
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
        'order_id' => 'required|string',
        'reason' => 'nullable|string',
        'items' => 'required|array',
        'items.*.product_id' => 'required|integer',
        'items.*.quantity' => 'required|integer|min:1',
        ];
    }
}
