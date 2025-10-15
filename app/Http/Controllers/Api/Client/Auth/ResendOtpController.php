<?php

namespace App\Http\Controllers\Api\Client\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\Client\Auth\ResendOtpRequest;
use App\Mail\SendOtpMail;
use App\Models\Client;
use Illuminate\Support\Facades\Mail;

class ResendOtpController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(ResendOtpRequest $request)
    {
        $client = Client::where('phone', $request->phone)->first();

        // $data['otp'] = otpRandomNumbers();
        $data['otp'] = '000000';
        $client->otp = $data['otp'];
        $client->last_verification_code_sent_at;
        $client->verification_code_requests++;
        $client->save();

        // Mail::send($client->phone, new SendOtpMail($client));

        return successResponse('تم اعادة ارسال الكود بنجاح');
    }
}
