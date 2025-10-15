<?php



namespace App\Http\Requests\Api\Admin\governorate;

use Illuminate\Foundation\Http\FormRequest;

class GovernorateRequest extends FormRequest


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
            'name' => 'string|min:2',
            'delivery_price' => 'nullable|numeric|min:0'
        ];
    }
}
