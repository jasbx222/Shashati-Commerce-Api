<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class CheckPermission
{
    public function handle(Request $request, Closure $next, ...$permissions)
    {
        $user = $request->user();
        $hasPermission = false;
        foreach ($permissions as $permission) {
            if ($user && $user->can($permission) || $user->role==="super-admin") {
                $hasPermission = true;
                break;
            }
        }

        if (!$hasPermission) {
            return response()->json([
                'message' => 'You do not have permission to access this route.'
            ], 403);
        }

        return $next($request);
    }
}
