<?php

namespace App\Http\Controllers\Api\Client\Product;

use App\Http\Controllers\Controller;
use App\Http\Resources\Product\ProductResource;
use App\Models\Product;
use Illuminate\Http\Request;

class LastProductWithOfferController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(Request $request)
    {
        return ProductResource::collection(Product::where('is_offer', true)->latest()->get()); 
    }
}
