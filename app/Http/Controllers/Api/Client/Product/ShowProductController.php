<?php

namespace App\Http\Controllers\Api\Client\Product;

use App\Http\Controllers\Controller;
use App\Http\Resources\Product\ProductResource;
use App\Models\Product;
use Illuminate\Http\Request;

class ShowProductController extends Controller
{
    public function __invoke(Product $product)
    {
        $suggestedProducts = Product::query()
            ->where('category_id', $product->category_id)
            ->whereKeyNot($product->id)
            ->inRandomOrder()
            ->limit(4)
            ->get();
    
        return response()->json([
            'product' => new ProductResource($product),
            'suggested_products' => ProductResource::collection($suggestedProducts),
        ]);
    }
    
}
