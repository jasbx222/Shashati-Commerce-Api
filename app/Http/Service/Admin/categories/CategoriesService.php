<?php


namespace App\Http\Service\Admin\categories;

use App\Helpers\ImageUploader;
use App\Helpers\ImageUploaderAds;
use App\Http\Resources\Admin\Category\CategoryResource;
use App\Models\Category;

class CategoriesService
{


    // get all Categories with relation ships 


    public function index()
    {
        $Categories = Category::with('products')->get();
   
            return response()->json([
            'Categories' => CategoryResource::collection($Categories),
        ]);
    }



    public function show($category)
    {
     

        return new CategoryResource($category);
    }



 public function store(array $data)
{
    // إنشاء uploader
    $uploader = new ImageUploader();

    // رفع الصورة أو الاحتفاظ بالمسار إذا موجود
    $data['image'] = $uploader->upload($data['image']);

    // إنشاء المنتج
    $cateories = Category::create($data);

    // تجهيز رابط كامل للصورة قبل الإرجاع (اختياري)
    $cateories->image = $uploader->getUrl($cateories->image);

    return response()->json($cateories, 201);
}



    public function destroy($category)
    {
        $category->delete();
        return response()->noContent();
    }
}
