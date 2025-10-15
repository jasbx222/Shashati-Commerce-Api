<?php

namespace App\Http\Controllers\Api\Admin\categories;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\Admin\categories\CategoriesRequest;
use App\Models\Category;
use Illuminate\Http\JsonResponse;
use App\Http\Service\Admin\categories\CategoriesService;
class CategoriesController extends Controller
{
    /**
    
     */
    private  $category;

    /**
     * CategoriesController constructor.
     *

     */
    public function __construct(CategoriesService $categories)
    {
        $this->category = $categories;
    }

    /**
     * جلب جميع التصنيفات مع العلاقات
     *
     * @return JsonResponse
     */
    public function index(): JsonResponse
    {
        return $this->category->index();
    }

    /**
     * عرض تصنيف واحد
     *
     * @param Category $category
     * @return JsonResponse
     */
  
  public function show(Category $category)
    {
        
        return $this->category->show($category);
    }
    /**
     * إنشاء تصنيف جديد بعد التحقق من البيانات
     *
     * @param CategoriesRequest $request
     * @return JsonResponse
     */
    public function store(CategoriesRequest $request)
    {
        return $this->category->store($request->validated());
    }

    /**
     * تحديث تصنيف موجود
     *
     * @param CategoriesRequest $request
     * @param Category $category
     * @return JsonResponse
     */
    // public function update(CategoriesRequest $request, Category $category): JsonResponse
    // {
    //     return $this->category->update($request->validated(), $category);
    // }

    /**
     * حذف تصنيف
     *
     * @param Category $category
     * @return JsonResponse
     */
    public function destroy(Category $category)
    {
        return $this->category->destroy($category);
    }
}
