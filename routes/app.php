<?php

use App\Http\Controllers\Api\Admin\order_preparers\OrderPreparerAuthController;
use App\Http\Controllers\Api\Admin\order_preparers\OrderPreparerController;
use App\Http\Controllers\Api\Client\AccountStatements\AccountStatementController;
use App\Http\Controllers\Api\Client\Address\AddressController;
use App\Http\Controllers\Api\Client\Ads\AdsController;
use App\Http\Controllers\Api\Client\Auth\ChangePasswordController;
use App\Http\Controllers\Api\Client\Auth\CheckOtpController;
use App\Http\Controllers\Api\Client\Auth\DeleteAccountController;
use App\Http\Controllers\Api\Client\Auth\ForgetPasswordController;
use App\Http\Controllers\Api\Client\Auth\GuestLoginController;
use App\Http\Controllers\Api\Client\Auth\LoginController;
use App\Http\Controllers\Api\Client\Auth\LogoutController;
use App\Http\Controllers\Api\Client\Auth\RegisterController;
use App\Http\Controllers\Api\Client\Auth\ResendOtpController;
use App\Http\Controllers\Api\Client\Auth\ResetPasswordController;
use App\Http\Controllers\Api\Client\Category\CategoryController;
use App\Http\Controllers\Api\Client\ContactInfo\ContactInfoController;
use App\Http\Controllers\Api\Client\Coupon\CouponController;
use App\Http\Controllers\Api\Client\Favorite\FavoriteController;
use App\Http\Controllers\Api\Client\Favorite\ToggleFavoriteController;
use App\Http\Controllers\Api\Client\Governorate\GovernorateController;
use App\Http\Controllers\Api\Client\Order\OrderController;
use App\Http\Controllers\Api\Client\Product\LastProductController;
use App\Http\Controllers\Api\Client\Product\LastProductWithOfferController;
use App\Http\Controllers\Api\Client\Product\ProductController;
use App\Http\Controllers\Api\Client\Product\ShowProductController;
use App\Http\Controllers\Api\Client\Product\TopSellingProductsController;
use App\Http\Controllers\Api\Client\Profile\ProfileController;
use App\Http\Controllers\Api\Client\ReturnRequest\ReturnRequestController;
use App\Http\Controllers\Api\Client\Search\DeleteSearchHistoryController;
use App\Http\Controllers\Api\Client\Search\SearchHistoryController;
use App\Http\Controllers\Api\Client\SocialMedia\SocialMediaLinkController;
use App\Http\Controllers\Api\Client\TermsAndCondition\TermsAndConditionController;
use App\Http\Controllers\Notification\NotificationController;
use App\Http\Middleware\VerifyClientStatus;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::prefix('v1')->middleware(VerifyClientStatus::class)->group(function () {
    //   auth
   Route::prefix('auth')->group(function () {
        Route::post('login', LoginController::class);
        Route::post('register', RegisterController::class);

        //  otp
        Route::post('otp-check', CheckOtpController::class);
        Route::post('otp-resend', ResendOtpController::class);

        //  Password
        Route::post('forget-password', ForgetPasswordController::class);
        Route::post('reset-password', ResetPasswordController::class);

        Route::middleware('auth:sanctum')->group(function () {
            Route::post('logout', LogoutController::class);
            Route::delete('delete-account', DeleteAccountController::class);
            //  password
            Route::post('change-password', ChangePasswordController::class);
        });
    });

    Route::middleware('auth:sanctum')->group(function () {

        // Profile
        Route::prefix('profile')->group(function () {
            Route::get('', [ProfileController::class, 'get']);
            Route::post('', [ProfileController::class, 'update']);
        });

        // Search
        Route::prefix('search')->group(function () {
            //  Search History
            Route::prefix('history')->group(function () {
                Route::get('', SearchHistoryController::class);
                Route::delete('{searchHistory}', DeleteSearchHistoryController::class);
            });
        });

        // Favorite
        Route::prefix('favorite')->group(function () {
            Route::get('', FavoriteController::class);
            Route::put('toggle/{product}', ToggleFavoriteController::class);
        });

        // Order
      Route::prefix('order')->middleware('auth:sanctum')->group(function () {
    Route::get('', [OrderController::class, 'get'])->middleware('checkTime');
    Route::get('/products/{order}', [OrderController::class, 'products'])->middleware('checkTime');
    
    // إنشاء طلب إرجاع جديد
    Route::post('/returns', [ReturnRequestController::class, 'store']);
    
    Route::get('{order}', [OrderController::class, 'show'])->middleware('checkTime');
    Route::post('', [OrderController::class, 'create'])->middleware('checkTime');
});


        //  Address
        Route::prefix('address')->group(function () {
            Route::get('', [AddressController::class, 'index']);
            Route::post('', [AddressController::class, 'create']);
            Route::put('{address}', [AddressController::class, 'update']);
            Route::delete('{address}', [AddressController::class, 'delete']);
        });

        // Coupon
        Route::prefix('coupon')->group(function () {
            Route::put('check', CouponController::class);
        });
    });

     // Notification
        Route::prefix('notification')->group(function() {
            Route::get('', [NotificationController::class, 'index']);
            Route::post('store-fcm-token', [NotificationController::class, 'storeFcmToken']);
            Route::put('read-all', [NotificationController::class, 'readAllNotifications']);
        });
    })  ->middleware('auth:sanctum');

  
    //  AccountStatement

    Route::apiResource('account-statements', AccountStatementController::class)->middleware('auth:sanctum');
 Route::get('account-statements/download/{statement}', [AccountStatementController::class, 'downloadPdf'])
     ->middleware('auth:sanctum');

    //  Governorate
    Route::prefix('governorate')->group(function () {
        Route::get('', GovernorateController::class);
    });

    //  Social media
    Route::get('social-media-link', SocialMediaLinkController::class);

    //  Contact Info
    Route::get('contact-info', ContactInfoController::class);

    //  Terms and Condition
    Route::get('terms-and-condition', TermsAndConditionController::class);
    //  Most By





    // عرض كل طلبات الإرجاع الخاصة بالعميل
    // Route::get('/returns', [ReturnRequestController::class, 'index'])
    //     ->name('returns.index')->middleware('auth:sanctum');

    // عرض تفاصيل طلب إرجاع معين
    // Route::get('/returns/{id}', [ReturnRequestController::class, 'show'])
    //     ->name('returns.show');





   

// الدخول ك ضيف 
  //  Category
    Route::prefix('v1/category')->group(function () {
        Route::get('', CategoryController::class);
    });

    
    //  Product
    Route::prefix('v1/product')->group(function () {
        Route::get('', [ProductController::class, 'index']);
        Route::get('search', [ProductController::class, 'search']);
        Route::get('is_offer', [ProductController::class, 'is_offer']);

        Route::get('last-product', LastProductController::class);
        Route::get('product-with-offer', LastProductWithOfferController::class);
        Route::get('top-selling-products', TopSellingProductsController::class);
        Route::get('{product}', ShowProductController::class);
    });


     //  Ads
    Route::prefix('v1/ads')->group(function () {
        Route::get('', AdsController::class);
    });