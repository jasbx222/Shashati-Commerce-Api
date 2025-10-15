<?php

namespace App\Http\Controllers\Api\Client\Favorite;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\Request;

class ToggleFavoriteController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(Product $product, Request $request)
    {
        $request->user()->favorites()->toggle($product->id);

        return successResponse('تم بنجاح');
    }
}
