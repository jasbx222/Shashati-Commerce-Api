<?php

namespace App\Http\Requests\Api\Admin\client;

use Illuminate\Foundation\Http\FormRequest;

class ClientRequest extends FormRequest
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
            'name' => ['required', 'string', 'max:255'],
            'merchant'=> ['required', 'string', 'max:255'],
            'branch_id'=>['required','exists:branches,id'],
            'phone' => ['required', 'numeric', 'unique:clients,phone'],
            'password' => ['required', 'string', 'min:8', 'max:255'],
        ];
    }

    /**
     * Custom error messages for validation rules.
     */
    public function messages(): array
    {
        return [
            'name.required' => 'الاسم مطلوب.',
            'merchant.required' => 'اسم التاجر مطلوب  .',
            'name.string' => 'يجب أن يكون الاسم نصيًا.',
            'name.max' => 'الاسم لا يجب أن يتجاوز 255 حرفًا.',

            'phone.required' => 'رقم الهاتف مطلوب.',
            'phone.numeric' => 'يجب أن يكون رقم الهاتف رقمًا.',
            'phone.unique' => 'رقم الهاتف مستخدم بالفعل.',

            'password.required' => 'كلمة المرور مطلوبة.',
            'password.string' => 'كلمة المرور يجب أن تكون نصًا.',
            'password.min' => 'كلمة المرور يجب أن تكون على الأقل 8 أحرف.',
            'password.max' => 'كلمة المرور لا يجب أن تتجاوز 255 حرفًا.',
        ];
    }
}
