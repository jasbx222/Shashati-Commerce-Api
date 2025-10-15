<?php

namespace App\Http\Requests\Api\Client\Order;

use Illuminate\Foundation\Http\FormRequest;

class CreateOrderRequest extends FormRequest
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

            'products' => ['required', 'array', 'min:1'],
            'products.*.id' => ['required', 'exists:products,id'],
            'products.*.quantity' => ['required', 'integer', 'min:1'],

            'coupon_code' => ['nullable', 'string', 'exists:coupons,code'],
            'address_id' => ['required', 'exists:addresses,id'],
        ];
    }

    /**
     * Customize the validation error messages.
     */
    public function messages(): array
    {
        return [
            'products.required' => 'يجب تحديد قائمة المنتجات.',
            'products.array' => 'يجب أن تكون المنتجات في صيغة قائمة.',
            'products.*.id.required' => 'يجب تحديد معرف المنتج.',
            'products.*.id.exists' => 'المنتج غير موجود.',
            'products.*.quantity.required' => 'يجب تحديد الكمية المطلوبة.',
            'products.*.quantity.integer' => 'الكمية يجب أن تكون رقمًا صحيحًا.',
            'products.*.quantity.min' => 'الكمية يجب أن تكون على الأقل 1.',

            'coupon_code.exists' => 'كود الكوبون غير صالح.',
            'address_id.required' => 'يجب تقديم تفاصيل العنوان.',
        ];
    }
}
