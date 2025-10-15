<?php



namespace App\Http\Requests\Api\Admin\product;

use Illuminate\Foundation\Http\FormRequest;

class ProductRequest extends FormRequest


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
         'name'        => 'required|string|max:255',
            'description' => 'required|string',
            'category_id' => 'required|exists:categories,id',
            'quantity'    => 'required|integer|min:0',
            'price'       => 'required|numeric|min:0',
            'price_after' => 'nullable|numeric|min:0',
            'is_offer'    => 'boolean',
          'images'      => 'required|array',       
        'images.*'    => 'file|mimes:jpg,jpeg,png,gif|max:2048',
        ];
    }
}
