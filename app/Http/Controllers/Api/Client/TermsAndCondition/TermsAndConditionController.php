<?php

namespace App\Http\Controllers\Api\Client\TermsAndCondition;

use App\Http\Controllers\Controller;
use App\Http\Resources\TermsAndCondition\TermsAndConditionResource;
use App\Models\TermsAndCondition;
use Illuminate\Http\Request;

class TermsAndConditionController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(Request $request)
    {
        return TermsAndConditionResource::make(TermsAndCondition::first());
    }
}
