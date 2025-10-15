<?php

namespace App\Http\Service\Admin\product;

use App\Filament\Resources\ProductResource;
use App\Helpers\ImageUploader;
use App\Http\Resources\Product\ProductResource as ProductProductResource;
use App\Models\Image;
use Illuminate\Http\UploadedFile;
use App\Models\Product;


class ProductService 
{


    // عرض كل المنتجات مع pagination
    public function index()
    {
        $products = Product::with('category')->filter()->paginate(15);
     return response()->json([
            'products' =>  ProductProductResource::collection($products),
            'meta' => [
                'current_page' => $products->currentPage(),
                'last_page' => $products->lastPage(),
                'per_page' => $products->perPage(),
                'total' => $products->total(),
            ]
        ]);
    }

    //  عرض منتج واحد
    public function show($product)
    {
        return new  ProductProductResource($product);
    }



// ProductService.php
public function store(array $data)
{
    $product = Product::create($data);

    if(isset($data['images']) && count($data['images'])) {
        $uploader = new ImageUploader();

        // إذا كانت صورة واحدة وتحولت لـ UploadedFile بدل المصفوفة
        $images = is_array($data['images']) ? $data['images'] : [$data['images']];

        foreach($images as $image) {
            $path = $uploader->uploadMany([$image]); // نرسل مصفوفة
            Image::create([
                'product_id' => $product->id,
                'image' => $path[0], // uploadArray يرجع مصفوفة
            ]);
        }
    }

    $product->load('images'); 
    return response()->json($product, 201);
}


public function update(array $data, $product)
{
    $product->update($data);

    if(isset($data['images']) && count($data['images'])) {
        $uploader = new ImageUploader();

        // حذف الصور القديمة إذا تريد تحديث كامل
        $product->images()->delete();

        foreach($data['images'] as $image) {
            $path = $uploader->uploadMany($image);
            Image::create([
                'product_id' => $product->id,
                'image' => $path,
            ]);
        }
    }

    $product->load('images');
    return response()->json($product, 200);
}










    //  حذف منتج
    public function destroy( $product)
    {
        $product->delete();
        return response()->json(['message' => 'تم حذف المنتج بنجاح']);
    }
}
