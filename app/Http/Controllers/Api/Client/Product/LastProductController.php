<?php

namespace App\Http\Controllers\Api\Client\Product;

use App\Http\Controllers\Controller;
use App\Http\Resources\Product\ProductResource;
use App\Models\Product;
use Illuminate\Http\Request;

class LastProductController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(Request $request)
    {
        return ProductResource::collection(Product::latest()->limit(20)->get());
    }
}
