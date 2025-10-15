<?php

namespace App\Http\Controllers\Api\Client\Ads;

use App\Http\Controllers\Controller;
use App\Http\Resources\Ads\AdsResource;
use App\Models\Ads;
use Illuminate\Http\Request;

class AdsController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(Request $request)
    {
        return AdsResource::collection(Ads::type()->get());
    }
}
