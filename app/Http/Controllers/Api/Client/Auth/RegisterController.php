<?php

namespace App\Http\Controllers\Api\Client\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\Client\Auth\RegisterRequest;
use App\Mail\SendOtpMail;
use App\Models\Client;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class RegisterController extends Controller
{
    /**
     * Handle the incoming request.
     */
 public function __invoke(RegisterRequest $request)
{
    $data = $request->validated();

    // صياغة رقم الهاتف بشكل دائم +964
    $data['phone'] = '+964' . preg_replace('/^0+/', '', $data['phone']);

    // تحقق من عدم تكرار الرقم
    if (Client::where('phone', $data['phone'])->exists()) {
        return response()->json([
            'message' => 'رقم الهاتف مستخدم من قبل'
        ], 422);
    }

    // تشفير الباسوورد
    $data['password'] = bcrypt($data['password']);

    // OTP (مؤقتًا ثابت، لكن يفضل جعله عشوائي بالإنتاج)
    $data['otp'] = '000000';
    $data['last_verification_code_sent_at'] = now();
    $data['verification_code_requests'] = 1;

    $client = Client::create($data);

    // إرسال OTP عالإيميل
    // Mail::to($client->email)->send(new SendOtpMail($client));

    return successResponse('تم انشاء الحساب بنجاح, ستصلك رسالة التاكيد ع الايميل');
}

}
