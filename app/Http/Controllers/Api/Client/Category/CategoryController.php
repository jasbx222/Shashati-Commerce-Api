<?php

namespace App\Http\Controllers\Api\Client\Category;

use App\Http\Controllers\Controller;
use App\Http\Resources\Category\CategoryResource;
use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(Request $request)
    {
        $categories = Category::parentFilter()->get();

        return CategoryResource::collection($categories);
    }
}
