<?php

namespace App\Http\Controllers\Api\Client\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\Client\Auth\CheckOtpRequest;
use App\Http\Resources\Client\ClientResource;
use App\Models\Client;
use Illuminate\Http\Request;

class CheckOtpController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(CheckOtpRequest $request)
    {
        $attributes = $request->validated();

        $client = Client::query()
            ->where('phone', $attributes['phone'])
            ->first();

        if ($client->isVerified()) {
            return failedResponse('الحساب مؤكد مسبقا');
        }

        $client->otp = null;
        $client->phone_verified_at = now();
        $client->is_confirmed = true;
        $client->verification_code_requests++;
        $client->last_verification_code_sent_at = now();
        $client->saveQuietly();

        return
            ClientResource::make($client)->additional(
                [
                    'token' => $client->createToken($client->id)->plainTextToken,
                ]
            );
    }
}
