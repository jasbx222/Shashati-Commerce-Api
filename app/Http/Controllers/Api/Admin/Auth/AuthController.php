<?php

namespace App\Http\Controllers\Api\Admin\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\Admin\auth\LoginRequest;
use App\Http\Service\Admin\Auth\AuthService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    /**
     * @var AuthService
     */
    private AuthService $auth;

    /**
     * AuthController constructor.
     *
     * @param AuthService $auth
     */
    public function __construct(AuthService $auth)
    {
        $this->auth = $auth;
    }

    /**
     * تسجيل الدخول
     *
     * @param LoginRequest $request
     * @return JsonResponse
     */
    public function login(LoginRequest $request): JsonResponse
    {

        return $this->auth->login($request);
    }
    public function profile(): JsonResponse
    {
      
        return $this->auth->profile();
    }
    public function logout(Request $request): JsonResponse
    {
        return $this->auth->logout( $request);
    }

public function update(Request $request)
{

    return $this->auth->update( $request);

}

}
