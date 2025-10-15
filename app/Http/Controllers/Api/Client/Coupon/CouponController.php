<?php

namespace App\Http\Controllers\Api\Client\Coupon;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\Client\Coupon\CouponRequest;
use App\Models\Coupon;
use Illuminate\Http\Request;

class CouponController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(CouponRequest $request)
    {
        $coupon = Coupon::where('code', $request->input('code'))->first();

        if (!$coupon) {
            return errorResponse('خطأ في الكوبون ');
        }

        if (!$coupon->isValid()) {
            return errorResponse('الكوبون منتهي الصلاحية');
        }
        return response()->json([
            'message' => 'الكوبون صحيح',
            'data' => [
                'discount' => $coupon->value,
                'type' => $coupon->type,
            ],
        ], 200);
    }
}

