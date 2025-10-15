<?php

namespace App\Http\Controllers\Api\Admin\Ads;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\Admin\ads\AdsStoreRequest;
use App\Http\Service\Admin\ads\AdsService;
use App\Models\Ads;
use Illuminate\Http\JsonResponse;

class AdsController extends Controller
{
    /**
     * @var AdsService
     */
    private AdsService $ads;

    /**
     * AdsController constructor.
     *
     * @param AdsService $ads
     */
    public function __construct(AdsService $ads)
    {
        $this->ads = $ads;
    }

    /**
     * عرض قائمة الإعلانات مع دعم الـ pagination
     *
     * @return JsonResponse
     */
    public function index(): JsonResponse
    {
        return $this->ads->index();
    }

    /**
     * عرض إعلان واحد حسب الـ id
     *
     * @param Ads $ad
     * @return JsonResponse
     */
    public function show(Ads $ad)
    {
        return $this->ads->show($ad);
    }

    /**
     * إنشاء إعلان جديد بعد التحقق من البيانات
     *
     * @param AdsStoreRequest $request
     * @return JsonResponse
     */
    public function store(AdsStoreRequest $request): JsonResponse
    {
        return $this->ads->store($request->validated());
    }

    /**
     * تحديث إعلان موجود
     *
     * @param AdsStoreRequest $request
     * @param Ads $ad
     * @return JsonResponse
     */
    public function update(AdsStoreRequest $request, Ads $ad): JsonResponse
    {
        return $this->ads->update($request->validated(), $ad);
    }

    /**
     * حذف إعلان
     *
     * @param Ads $ad
     * @return JsonResponse
     */
    public function destroy(Ads $ad): JsonResponse
    {
        return $this->ads->destroy($ad);
    }
}
