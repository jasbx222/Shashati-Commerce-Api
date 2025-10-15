<?php

namespace App\Http\Controllers\Api\Admin\coupon;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\Admin\coupon\CouponRequest;
use App\Http\Service\Admin\coupon\CouponService;
use App\Models\Coupon;
use Illuminate\Http\JsonResponse;

class CouponController extends Controller
{
    /**
     * @var CouponService
     */
    private CouponService $coupon;

    /**
     * CouponController constructor.
     *
     * @param CouponService $coupon
     */
    public function __construct(CouponService $coupon)
    {
        $this->coupon = $coupon;
    }

    /**
     * عرض قائمة جميع الكوبونات
     *
     * @return JsonResponse
     */
    public function index()
    {
        return $this->coupon->index();
    }

    /**
     * إنشاء كوبون جديد
     *
     * @param CouponRequest $request
     * @return JsonResponse
     */
    public function store(CouponRequest $request): JsonResponse
    {
        return $this->coupon->store($request->validated());
    }

    /**
     * عرض كوبون محدد
     *
     * @param Coupon $coupon
     * @return JsonResponse
     */
    public function show(Coupon $coupon): JsonResponse
    {
        return $this->coupon->show($coupon);
    }

    /**
     * تحديث كوبون موجود
     *
     * @param CouponRequest $request
     * @param Coupon $coupon
     * @return JsonResponse
     */
    public function update(CouponRequest $request, Coupon $coupon): JsonResponse
    {
        return $this->coupon->update($request->validated(), $coupon);
    }

    /**
     * حذف كوبون
     *
     * @param Coupon $coupon
     * @return JsonResponse
     */
    public function destroy(Coupon $coupon): JsonResponse
    {
        return $this->coupon->destroy($coupon);
    }
}
