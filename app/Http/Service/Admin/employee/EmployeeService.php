<?php

namespace App\Http\Service\Admin\employee;

use App\Http\Resources\Admin\employee\EmployeeResource;
use App\Http\Resources\Admin\employee\PermissionResource;
use App\Http\Resources\Admin\employee\UserResource;
use App\Models\Employee;
use App\Models\User;
use Spatie\Permission\Models\Permission;

class EmployeeService
{
    public function store($request)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
  
            'password' => 'required|string|min:6',
            'permissions' => 'nullable|array',
            'permissions.*' => 'integer|exists:permissions,id',
        ]);

        $employee = User::create([
            'name' => $data['name'],
            'email' => $data['email'],
     
            'password' => bcrypt($data['password']),
        ]);

        if (!empty($data['permissions'])) {
            $validPermissions = Permission::whereIn('id', $data['permissions'])
                ->where('guard_name', 'web')
                ->pluck('name')
                ->toArray();

            $employee->givePermissionTo($validPermissions);
        }

        return response()->json(['message' => 'Employee created successfully', 'employee' => $employee]);
    }

    public function update($request, $employee)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:employees,email,' . $employee->id,
         
            'password' => 'nullable|string|min:6',
            'permissions' => 'nullable|array',
            'permissions.*' => 'integer|exists:permissions,id',
        ]);

        $employee->update([
            'name' => $data['name'],
            'email' => $data['email'],
     
            'password' => isset($data['password']) ? bcrypt($data['password']) : $employee->password,
        ]);

        if (!empty($data['permissions'])) {
            $validPermissions = Permission::whereIn('id', $data['permissions'])
                ->where('guard_name', 'web')
                ->pluck('name')
                ->toArray();

            $employee->syncPermissions($validPermissions);
        }

        return response()->json(['message' => 'Employee updated successfully', 'employee' => $employee]);
    }

    public function getAllPermissions()
    {
        $permissions = Permission::all();
        return PermissionResource::collection($permissions);
    }


    public function index()
    {

        $employees = User::where('role', 'admin')->get();

        return UserResource::collection($employees);
    }


    public function delete($employee)
    {

        $employee->delete();

        return response()->noContent();
    }



    public function show( $employee)
    {
        return new UserResource($employee);
    }
}
