<?php

namespace App\Http\Middleware;

use App\Exceptions\AppException;
use App\Helpers\Status;
use App\Models\Client;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class VerifyClientStatus
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (auth()->check() && auth()->user() instanceof Client && auth()->user()->is_blocked) {
            throw new AppException('حسابك محظور من الادمن, يرجى مراجعته', Status::HTTP_CUSTOM_ACOUNT_NOT_ACTIVE);
        }

        return $next($request);
    }
}
