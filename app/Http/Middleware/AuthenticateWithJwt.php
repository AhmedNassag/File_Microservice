<?php

namespace App\Http\Middleware;

use Closure;
use Tymon\JWTAuth\Facades\JWTAuth;
use Tymon\JWTAuth\Exceptions\JWTException;

class AuthenticateWithJwt
{
    public function handle($request, Closure $next)
    {
        try {
            $user = JWTAuth::getToken();
            // $roles       = JWTAuth::getPayload()->get('roles');
            // $permissions = JWTAuth::getPayload()->get('permissions');

            // // Example: Check if user has permission to create a post
            // if (!in_array('create-post', $permissions)) {
            //     return response()->json(['error' => 'Unauthorized'], 403);
            // }

            // Pass user, roles, and permissions to the request
            $request->merge(['user' => $user/*, 'roles' => $roles, 'permissions' => $permissions*/]);
        } catch (JWTException $e) {
            return response()->json(['error' => 'Token is invalid or missing'], 401);
        }

        return $next($request);
    }
}
