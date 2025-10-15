<?php

namespace App\Http\Controllers\Api\Client\Governorate;

use App\Http\Controllers\Controller;
use App\Http\Resources\Governorate\GovernorateResource;
use App\Models\Governorate;
use Illuminate\Http\Request;

class GovernorateController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(Request $request)
    {
        return GovernorateResource::collection(Governorate::all());
    }
}
