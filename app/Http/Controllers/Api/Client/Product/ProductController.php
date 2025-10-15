<?php

namespace App\Http\Controllers\Api\Client\Product;

use App\Http\Controllers\Controller;
use App\Http\Resources\Product\ProductResource;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function index(Request $request)
    {
        $products = Product::filter()
            ->quantity()
            ->search()
            ->paginate(10);

        $productCount = 0;

        if ($request->has('category_id')) {
            $category = Category::find($request->input('category_id'));

            if ($category) {
                $productCount = $category->product_count;
            }
        }

        return ProductResource::collection($products)->additional([
            'category_product_count' => $productCount,
        ]);
    }
    
    public function search(Request $request)
    {
        $query = Product::query();


        if ($request->filled('category_id')) {
            $query->where('category_id', $request->category_id);
        }

        if ($request->filled('name')) {
            $query->where('name', 'like', '%' . $request->name . '%');
        }

    
        $results = $query->get();

        return ProductResource::collection($results)->additional([
            'message' => 'Search results retrieved successfully.',
        ]);
    }

    public function is_offer()
    {
        return  ProductResource::collection(Product::where('is_offer', true)->get());
    }

}