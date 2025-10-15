<?php


namespace App\Http\Service\Admin\Auth;

use App\Http\Resources\Admin\employee\UserResource;
use App\Models\User;
use Google\Auth\Credentials\UserRefreshCredentials;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthService {
    // auth login admin

 public function login( $request)
    {
        $validated = $request->validated();

        if (!Auth::attempt($request->only('email', 'password'))) {
            return response()->json('Invalid credentials', 401);
        }

        $user = User::where('email', $validated['email'])->first();
 if ($request->filled('fcm_token')) {
        $user->update(['fcm_token' => $request->fcm_token]);
    }

        $tokenName = 'API Token for ' . $user->email;

       $token = $user->createToken($tokenName)->plainTextToken;
        return response()->json([
            'user'=>new UserResource($user),
            'token'=>$token
        ],200);
    }

        public function profile(){
            $user=User::first();
         $user->notify(new \App\Notifications\TestNotification());
        return response()->json([
            'profile'=>new UserResource($user),
        ]);
    }


public function update( $request)
{
    // التحقق من البيانات
    $data = $request->validate([
        'name' => 'sometimes|string|max:255',
        'email' => 'sometimes|email|unique:users,email,' . auth()->id(),
        'password' => 'sometimes|string|min:8',
    ]);

    $user = auth()->user();

    if (isset($data['name'])) {
        $user->name = $data['name'];
    }

    if (isset($data['email'])) {
        $user->email = $data['email'];
    }

    if (isset($data['password'])) {
        $user->password = Hash::make($data['password']);
    }

    $user->save();

    return response()->json([
        'status' => true,
        'message' => 'تم تحديث بياناتك بنجاح',
        'data' => $user
    ]);
}








    public function logout($request)
{
 
    $request->user()->currentAccessToken()->delete();

    return response()->json([
        'message' => 'تم تسجيل الخروج بنجاح',
    ], 200);
}

}