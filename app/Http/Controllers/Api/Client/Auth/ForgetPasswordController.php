<?php

namespace App\Http\Controllers\Api\Client\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\Client\Auth\ForgetPasswordRequest;
use App\Mail\SendOtpMail;
use App\Mail\SendOtpPasswordMail;
use App\Models\Client;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;

class ForgetPasswordController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(ForgetPasswordRequest $request)
    {
        $response = DB::transaction(function () use ($request) {
            // $token = otpRandomNumbers();
          $token = '000000';
            $client = Client::where('phone', $request->phone)->first();
    
            if (!$client) {
                return failedResponse('الحساب غير موجود');
            }
    
            DB::table('password_reset_tokens')->where('phone', $request->phone)->delete();
    
            DB::table('password_reset_tokens')->insert([
                'phone' => $request->phone,
                'token' => $token,
                'created_at' => now(),
            ]);
    
            // Mail::to($client->phone)->send(new SendOtpPasswordMaiL($token));
    
            return successResponse('تم ارسال الكود الخاص باعادة تعيين كلمة المرور الى بريدك الالكتروني');
        });
    
        return $response;
    }
}
