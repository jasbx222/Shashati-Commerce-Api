<?php

namespace App\Http\Controllers\Api\Client\Product;

// use App\Filament\Resources\ProductResource;
use App\Http\Controllers\Controller;
use App\Http\Resources\Product\ProductResource;
use App\Models\Product;

class TopSellingProductsController extends Controller
{

    public function __invoke()
    {
        $products = Product::withSum('orders as total_sold', 'order_product.quantity')
            ->orderByDesc('total_sold')
            ->take(5)
            ->get(['id', 'name', 'price']);

        return ProductResource::collection($products);
    }
}
