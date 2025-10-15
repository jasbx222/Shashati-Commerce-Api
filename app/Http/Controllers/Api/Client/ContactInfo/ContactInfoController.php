<?php

namespace App\Http\Controllers\Api\Client\ContactInfo;

use App\Http\Controllers\Controller;
use App\Http\Resources\ContactInfo\ContactInfoResource;
use App\Models\ContactInfo;
use Illuminate\Http\Request;

class ContactInfoController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(Request $request)
    {
        return ContactInfoResource::make(ContactInfo::first());
    }
}
