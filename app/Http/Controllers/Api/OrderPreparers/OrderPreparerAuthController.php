<?php

namespace App\Http\Controllers\Api\OrderPreparers;
use App\Exceptions\AppException;
use App\Helpers\Status;
use App\Http\Controllers\Controller;
use App\Http\Requests\Api\Client\Auth\LoginRequest;
use App\Http\Resources\Client\ClientResource;
use App\Models\Client;
use App\Models\OrderPreparer;
use App\Policies\OrderPolicy;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
class OrderPreparerAuthController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function login(LoginRequest $request)
    {
        $client = OrderPreparer::where('phone', $request->phone)->first();

        if (!$client) {
            return failedResponse('البريد الالكتروني خاطئ أو غير موجود');
        }

        if (!Hash::check($request->password, $client->password)) {
            return failedResponse('كلمة المرور غير صحيحة');
        }
        if (!$client->is_active) {
            throw new AppException('حسابك محظور من الادمن, يرجى مراجعته', Status::HTTP_CUSTOM_ACOUNT_NOT_ACTIVE);
        }


    

        return
            ClientResource::make($client)->additional(
                [
                    'token' => $client->createToken($client->id)->plainTextToken,
                ]);

    }

    public function logout(Request $request)
{
 
    $request->user()->currentAccessToken()->delete();

    return response()->json([
        'message' => 'تم تسجيل الخروج بنجاح',
    ], 200);
}
}
