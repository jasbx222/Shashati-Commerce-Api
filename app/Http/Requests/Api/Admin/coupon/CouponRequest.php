<?php



namespace App\Http\Requests\Api\Admin\coupon;

use Illuminate\Foundation\Http\FormRequest;

class CouponRequest extends FormRequest


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
            'code' => 'required|string|max:255|unique:coupons,code,' . $this->id,
            'type' => 'required|in:fixed,percentage', 
            'value' => 'required|numeric|min:0',
            'minimum_order_amount' => 'nullable|integer|min:0',
            'expires_at' => 'nullable|date|after:today',
            'name' => 'nullable|string|max:100',
        ];
    }
}
