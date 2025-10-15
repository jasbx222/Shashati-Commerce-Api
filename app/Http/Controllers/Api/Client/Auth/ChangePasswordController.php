<?php

namespace App\Http\Controllers\Api\Client\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\Client\Auth\ChangePasswordRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class ChangePasswordController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(ChangePasswordRequest $request)
    {
        $client = auth()->user();
        if (!Hash::check($request->old_password, $client->password)) {
            return failedResponse('كلمة المرور خاطئة');
        }

        /** @var User $user */
        $client->update([
            'password' => $request->password
        ]);

        return successResponse('تم تغيير كلمة المرور بنجاح');
    }
}
