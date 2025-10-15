<?php

namespace App\Http\Controllers\Api\Client\Auth;

use App\Exceptions\AppException;
use App\Helpers\Status;
use App\Http\Controllers\Controller;
use App\Http\Requests\Api\Client\Auth\LoginRequest;
use App\Http\Resources\Client\ClientResource;
use App\Models\Client;
use Illuminate\Support\Facades\Hash;


class LoginController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(LoginRequest $request)
    {
        $client = Client::where('phone', $request->phone)->first();



        if (!Hash::check($request->password, $client->password)) {
            return response()->json([
                'message' => 'كلمة المرور غير صحيحة'
            ], 401);
        }
        if (!$client->is_active) {
            throw new AppException('حسابك محظور من الادمن, يرجى مراجعته', Status::HTTP_CUSTOM_ACOUNT_NOT_ACTIVE);
        }
        return
            ClientResource::make($client)->additional(
                [
                    'token' => $client->createToken($client->id)->plainTextToken,
                ]
            );
    }
}
