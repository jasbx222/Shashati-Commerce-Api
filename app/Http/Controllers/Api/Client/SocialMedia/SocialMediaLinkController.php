<?php

namespace App\Http\Controllers\Api\Client\SocialMedia;

use App\Http\Controllers\Controller;
use App\Http\Resources\SocialMedia\SocialMediaLinkResource;
use App\Models\SocialMediaLink;
use Illuminate\Http\Request;

class SocialMediaLinkController extends Controller
{
       /**
     * Handle the incoming request.
     */
    public function __invoke()
    { 
        return SocialMediaLinkResource::collection(SocialMediaLink::all());
    }
}
