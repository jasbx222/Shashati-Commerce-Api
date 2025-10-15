<?php

namespace App\Http\Controllers\Api\Client\Profile;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\Client\Profile\UpdateProfileRequest;
use App\Http\Resources\Client\ClientResource;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class ProfileController extends Controller
{
    public function get()
    {
        return ClientResource::make(auth()->user());
    }

    public function update(UpdateProfileRequest $request)
    {
        $data = $request->validated();
        $client = auth()->user();
        if (isset($data['email']))
        {

            $client->is_confirmed = false;
            $client->phone_verified_at = null;
            $client->email = $data['email'];
            $client->otp = otpRandomNumbers();
            $client->last_verification_code_sent_at;
            $client->verification_code_requests++;
            $client->saveQuietly();

            // Mail::send( $client->email, new SendOtpMail($client));
            return successResponse('تم ارسال رمز التاكيد الى ايميلك الجديد , يرجى تاكيد حسابك');
        }

        $client->update($data);
        return successResponse('تم تحديث بياناتك بنجاح');
    }
}
