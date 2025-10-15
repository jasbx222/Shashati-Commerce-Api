<?php

namespace App\Http\Controllers\Api\Admin\governorate;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\Admin\governorate\GovernorateRequest;
use App\Http\Service\Admin\governorate\GovernorateService;
use App\Models\Governorate;
use Illuminate\Http\JsonResponse;

class GovernorateController extends Controller
{
    /**
     * @var GovernorateService
     */
    private GovernorateService $governorate;

    /**
     * GovernorateController constructor.
     *
     * @param GovernorateService $governorate
     */
    public function __construct(GovernorateService $governorate)
    {
        $this->governorate = $governorate;
    }

    /**
     * عرض جميع المحافظات
     *
     * @return JsonResponse
     */
    public function index(): JsonResponse
    {
        return $this->governorate->index();
    }

    /**
     * تحديث بيانات محافظة معينة
     *
     * @param GovernorateRequest $request
     * @param Governorate $governorate
     * @return JsonResponse
     */
    public function update(GovernorateRequest $request, Governorate $governorate): JsonResponse
    {
        return $this->governorate->update($request->validated(), $governorate);
    }
}
