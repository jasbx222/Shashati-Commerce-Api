<?php

namespace App\Http\Controllers\Api\Admin\product;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\Admin\product\ProductRequest;
use App\Http\Service\Admin\product\ProductService;
use App\Models\Product;
use Illuminate\Http\JsonResponse;
class ProductController extends Controller
{
    /**
 
     */
    private  $product;
    /**
     * ProductController constructor.
     *
   
     */
    public function __construct(ProductService $product)
    {
        $this->product = $product;
    }

    /**
     * عرض كل المنتجات مع دعم الـ pagination
     *
     * @return JsonResponse
     */
    public function index()
    {
        return $this->product->index();
    }

    /**
     * عرض منتج واحد
     *
     * @param Product $product
     * @return JsonResponse
     */
    public function show(Product $product)
    {
        return $this->product->show($product);
    }

    /**
     * إنشاء منتج جديد
     *
     * @param ProductRequest $request
     * @return JsonResponse
     */
public function store(ProductRequest $request)
{
    $product = $this->product->store($request->validated());
}



    /**
     * تحديث منتج موجود
     *
     * @param ProductRequest $request
     * @param Product $product
     * @return JsonResponse
     */
 public function update(ProductRequest $request, Product $product): JsonResponse
{
    return $this->product->update($request->validated(), $product);
}


    /**
     * حذف منتج
     *
     * @param Product $product
     * @return JsonResponse
     */
    public function destroy(Product $product): JsonResponse
    {
        return $this->product->destroy($product);
    }
}
