<?php


namespace App\Http\Requests\Api\Admin\employee;

use App\Models\Employee;
use Illuminate\Foundation\Http\FormRequest;

class EmployeeRequest extends FormRequest {



    public function authorize(): bool
    {
        return true;
    }

    public  function toArray(): array
    {
        return [
              'name' => 'string|max:255',
        'email' => 'required|email|unique:users,email',
        'branch_id' => 'required|exists:branches,id',
        'password' => 'required|string|min:6',
        'permissions' => 'nullable|array',
        'permissions.*' => 'integer|exists:permissions,id', 
        ];
    }
}

