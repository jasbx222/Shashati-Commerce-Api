<?php

namespace App\Http\Controllers\Api\Client\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class DeleteAccountController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(Request $request)
    {
        $client = auth()->user();
        $client->tokens()->delete();
        $client->is_confirmed = false;
        $client->verification_code_requests = 0;
        $client->phone_verified_at = null;
        $client->last_verification_code_sent_at = null;
        $client->fcm_token = null;
        $client->save();
        $client->delete();

        return successResponse('تم بنجاح');
    }
}
