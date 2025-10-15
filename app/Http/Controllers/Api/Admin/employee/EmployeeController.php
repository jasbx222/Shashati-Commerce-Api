<?php

namespace App\Http\Controllers\Api\Admin\employee;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\Admin\employee\EmployeeRequest;
use App\Http\Service\Admin\employee\EmployeeService as EmployeeEmployeeService;
use Illuminate\Http\Request;
use App\Models\Employee;
use App\Models\User;
use Spatie\Permission\Models\Permission;

/**
 * Class EmployeeController
 *
 * This controller handles all employee management operations
 * such as creating, updating, listing, deleting employees
 * and retrieving permissions.
 *
 * @package App\Http\Controllers\Api\Admin\employee
 */
class EmployeeController extends Controller
{
    /**
     * @var EmployeeEmployeeService
     */
    private $employee;

    /**
     * EmployeeController constructor.
     *
     * @param EmployeeEmployeeService $employee
     */
    public function __construct(EmployeeEmployeeService $employee)
    {
        $this->employee = $employee;
    }

    /**
     * Store a newly created employee.
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse|mixed
     */
    public function store(Request $request)
    {
        return $this->employee->store($request);
    }

    /**
     * Update the specified employee.
     *
     * @param Request $request
     * @param User $employee
     * @return \Illuminate\Http\JsonResponse|mixed
     */
    public function update(Request $request, User $employee)
    {
        return $this->employee->update($request, $employee);
    }

    /**
     * Get all available permissions for employees.
     *
     * @return \Illuminate\Http\JsonResponse|mixed
     */
    public function getAllPermissions()
    {
        return $this->employee->getAllPermissions();
    }

    /**
     * Display a listing of employees.
     *
     * @return \Illuminate\Http\JsonResponse|mixed
     */
    public function index()
    {
        return $this->employee->index();
    }

    /**
     * Remove the specified employee.
     *
     * @param User $employee
     * @return \Illuminate\Http\JsonResponse|mixed
     */
    public function destroy(User $employee)
    {
        return $this->employee->delete($employee);
    }
    public function show(User $employee)
    {
        return $this->employee->show($employee);
    }
}
