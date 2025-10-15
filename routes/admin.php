<?php

use App\Http\Controllers\Api\Admin\Ads\AdsController;
use App\Http\Controllers\Api\Admin\Auth\AuthController;
use App\Http\Controllers\Api\Admin\branches\BranchController;
use App\Http\Controllers\Api\Admin\categories\CategoriesController;
use App\Http\Controllers\Api\Admin\clients\ClientController;
use App\Http\Controllers\Api\Admin\contactInfo\ContactInfoController;
use App\Http\Controllers\Api\Admin\coupon\CouponController;
use App\Http\Controllers\Api\Admin\employee\EmployeeController;
use App\Http\Controllers\Api\Admin\governorate\GovernorateController;
use App\Http\Controllers\Api\Admin\home\HomeController;
use App\Http\Controllers\Api\Admin\OrderPreparers\OrderAdminPreparerController;
use App\Http\Controllers\Api\Admin\orders\OrdersController;
use App\Http\Controllers\Api\Admin\product\ProductController as ProductProductController;
use App\Http\Controllers\Api\Admin\product\TopSellingProductsController;
use App\Http\Controllers\Api\Admin\reports\ReportController;
use App\Http\Controllers\Api\Admin\termsAndCondition\TermsAndConditionController;
use App\Http\Controllers\Api\Admin\WorkTime\WorkTimeController;
use App\Http\Controllers\Api\Admin\AccountStatements\AccountStatementController;
use App\Http\Controllers\Api\Admin\invoice\InvoiceController;
use App\Http\Controllers\Api\Admin\permission\PermissionController;
use Illuminate\Support\Facades\Route;

// Auth routes
Route::post('/login', [AuthController::class, 'login']);

Route::middleware('auth:sanctum')->group(function () {

    // Authenticated user routes
    Route::get('profile', [AuthController::class,'profile']);
    Route::put('profile/update', [AuthController::class,'update']);
    Route::post('logout', [AuthController::class,'logout']);

    // Orders
    Route::apiResource('orders', OrdersController::class)->middleware('perm:view orders');
    Route::post('orders/{order}/status', [OrdersController::class, 'updateStatus'])->middleware('perm:update order status');

    // Home / Dashboard
    Route::get('get_status_sum', [HomeController::class, 'getOrdersCountByStatus'])->middleware('perm:view orders');
    Route::get('top_clients', [HomeController::class, 'topClients'])->middleware('perm:view clients');
    Route::get('dashboard-counts', [HomeController::class, 'CardsHomeCounts'])->middleware('perm:view orders');

    // Clients
    Route::apiResource('clients', ClientController::class)->middleware('perm:view clients');
    Route::post('clients/{client}/block', [ClientController::class, 'block_client'])->middleware('perm:block client');
    Route::get('client/{client}/orders', [ClientController::class, 'getAllOrders'])->middleware('perm:view client orders');

    // Ads
    Route::apiResource('ads', AdsController::class)->middleware([
        'index' => 'perm:view ads',
        'show' => 'perm:view ad details',
        'store' => 'perm:create ad',
        'update' => 'perm:update ad',
        'destroy' => 'perm:delete ad',
    ]);

    // Categories
    Route::apiResource('categories', CategoriesController::class)->middleware([
        'index' => 'perm:view categories',
        'show' => 'perm:view category',
        'store' => 'perm:create category',
        'update' => 'perm:update category',
        'destroy' => 'perm:delete category',
    ]);

    // Coupons
    Route::apiResource('coupons', CouponController::class)->middleware([
        'index' => 'perm:view coupons',
        'show' => 'perm:view coupon',
        'store' => 'perm:create coupon',
        'destroy' => 'perm:delete coupon',
    ]);
    Route::post('coupons/{coupon}/edit', [CouponController::class, 'update'])->middleware('perm:update coupon');

    // Products
    Route::apiResource('products', ProductProductController::class)->middleware([
        'index' => 'perm:view products',
        'show' => 'perm:view product',
        'store' => 'perm:create product',
        'update' => 'perm:update product',
        'destroy' => 'perm:delete product',
    ]);
    Route::get('top-selling-products', TopSellingProductsController::class)->middleware('perm:view top selling products');

    // Governorates
    Route::get('/governorates', [GovernorateController::class, 'index'])->middleware('perm:view governorates');
    Route::put('/governorates/{governorate}', [GovernorateController::class, 'update'])->middleware('perm:update governorate');

    // Terms & Conditions
    Route::get('/terms-and-conditions', [TermsAndConditionController::class, 'index'])->middleware('perm:view terms');
    Route::put('/terms-and-conditions/{term}', [TermsAndConditionController::class, 'update'])->middleware('perm:update terms');

    // Contact Info
    Route::get('/contact-info', [ContactInfoController::class, 'index'])->middleware('perm:view contact info');
    Route::put('/contact-info/{contact}', [ContactInfoController::class, 'update'])->middleware('perm:update contact info');

    // Reports
    Route::get('/reports_products',[ReportController::class,'products'])->middleware('perm:view reports');
    Route::get('/reports_coupons',[ReportController::class,'coupons'])->middleware('perm:view reports');
    Route::get('/reports_customers',[ReportController::class,'customers'])->middleware('perm:view reports');

    // Order Preparers
    Route::get('/order_prepares', [OrderAdminPreparerController::class, 'index'])->middleware('perm:view order preparers');
    Route::post('/order_prepares', [OrderAdminPreparerController::class, 'store'])->middleware('perm:create order preparer');
    Route::get('/order_prepares/{preparer}', [OrderAdminPreparerController::class, 'show'])->middleware('perm:view order preparer');
    Route::put('/order_prepares/{preparer}', [OrderAdminPreparerController::class, 'update'])->middleware('perm:update order preparer');
    Route::delete('/order_prepares/{preparer}', [OrderAdminPreparerController::class, 'destroy'])->middleware('perm:delete order preparer');

    // Branches
    Route::apiResource('branches', BranchController::class)->middleware([
        'index' => 'perm:view branches',
        'show' => 'perm:view branch',
        'store' => 'perm:create branch',
        'update' => 'perm:update branch',
        'destroy' => 'perm:delete branch',
    ]);

    // Employees
Route::apiResource('employees', EmployeeController::class)->middleware([
    'index' => 'perm:view employees',
    'store' => 'perm:create employee',
    'update' => 'perm:update employee',
    'destroy' => 'perm:delete employee',
]);

    Route::apiResource('account-statements', AccountStatementController::class)->middleware('auth:sanctum');

Route::get('permissions', [EmployeeController::class,'getAllPermissions']);
Route::post('permissions', [PermissionController::class,'roles']);

    // Work Time
    Route::get('work_time',[ WorkTimeController::class,'index'])->middleware('perm:view work times');
    Route::put('update_work_time/{work_time}',[ WorkTimeController::class,'update'])->middleware('perm:update work time');
 
 
    Route::post('add_work_time',[ WorkTimeController::class,'store'])->middleware('perm:create work time');
 
 
 
    Route::get('/invoice',[InvoiceController::class,'index']);
    Route::post('select/invoice',[InvoiceController::class,'deleteSelectedOrders']);
});
