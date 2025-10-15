<?php

namespace App\Http\Controllers\Api\Admin\permission;

use App\Http\Controllers\Controller;
use Spatie\Permission\Models\Permission;
class PermissionController extends Controller{
       public function roles()
    {
        $permissions = [
            // Orders
            'view orders', 'view order details', 'create order', 'update order', 'delete order', 'update order status',
            // Clients
            'view clients', 'view client details', 'create client', 'update client', 'delete client', 'block client', 'view client orders',
            // Ads
            'view ads', 'view ad details', 'create ad', 'update ad', 'delete ad',
            // Categories
            'view categories', 'view category', 'create category', 'update category', 'delete category',
            // Coupons
            'view coupons', 'view coupon', 'create coupon', 'update coupon', 'delete coupon',
            // Products
            'view products', 'view product', 'create product', 'update product', 'delete product', 'view top selling products',
            // Governorates
            'view governorates', 'update governorate',
            // Terms
            'view terms', 'update terms',
            // Contact Info
            'view contact info', 'update contact info',
            // Reports
            'view reports',
            // Order Preparers
            'view order preparers', 'create order preparer', 'view order preparer', 'update order preparer', 'delete order preparer',
            // employees
            'view  employees', 'create employees', 'delete employee', 'update  employee',
            // Branches
            'view branches', 'view branch', 'create branch', 'update branch', 'delete branch',
            // Work Time
            'view work times', 'update work time', 'create work time',
        ];

        foreach ($permissions as $permission) {
            Permission::firstOrCreate(['name' => $permission]);
        }

        return response()->json('add role success');
    }
}