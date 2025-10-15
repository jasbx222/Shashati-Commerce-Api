<?php

namespace App\Http\Controllers\Api\Client\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\Client\Auth\ResetPasswordRequest;
use App\Models\Client;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ResetPasswordController extends Controller
{
    public function __invoke(ResetPasswordRequest $request): JsonResponse
    {
        return DB::transaction(function () use ($request) {
            $client = Client::where('phone', $request->phone)->first();

            $resetToken = DB::table('password_reset_tokens')
                ->where('phone', $client->phone)
                ->where('token',  $request->token)
                ->first();

            if (!$client) {
               return failedResponse(' الايميل غير موجود');
            }

            if (!$resetToken) {
                return failedResponse('الكود خاطئ يرجى التأكد منه ');
            }


            DB::table('password_reset_tokens')->where('phone', $client->phone)->delete();

            $client->update([
                'password' => $request->password
            ]);
            $client->save();

            return successResponse('تم التحديث بنجاح');
        });
    }
}
