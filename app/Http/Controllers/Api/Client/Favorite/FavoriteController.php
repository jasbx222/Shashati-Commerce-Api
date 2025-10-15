<?php

namespace App\Http\Controllers\Api\Client\Favorite;

use App\Http\Controllers\Controller;
use App\Http\Resources\Favorite\FavoriteResource;
use App\Models\Favorite;
use Illuminate\Http\Request;

class FavoriteController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(Request $request)
    {
        return FavoriteResource::collection(Favorite::where('client_id', auth()->user()->id)->get());
    }
}
