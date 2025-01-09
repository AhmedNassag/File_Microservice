<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Tymon\JWTAuth\Facades\JWTAuth;
use Tymon\JWTAuth\Exceptions\JWTException;

class JwtMiddleware
{

    public function handle(Request $request, Closure $next)
    {
        /*try
        {
            // $user = \Tymon\JWTAuth\Facades\JWTAuth::parseToken()->authenticate();
            $token = \Tymon\JWTAuth\Facades\JWTAuth::getToken();
            // $roles       = \Tymon\JWTAuth\Facades\JWTAuth::getPayload()->get('roles');
            // $permissions = \Tymon\JWTAuth\Facades\JWTAuth::getPayload()->get('permissions');
        }
        catch (\Exception $e)
        {
            if ($e instanceof \Tymon\JWTAuth\Exceptions\TokenInvalidException)
            {
                return response()->json(['status' => 'Token is Invalid']);
            }
            else if ($e instanceof \Tymon\JWTAuth\Exceptions\TokenExpiredException)
            {
                return response()->json(['status' => 'Token is Expired']);
            }
            else
            {
                return response()->json(['status' => 'Token not found']);
            }
        }*/

        try {
            // Try to get the token from the request
            $token = JWTAuth::getToken();
            
            // Check if the token is invalid
            if (!$token) {
                return response()->json(['status' => 'Token not provided'], 401);
            }

            // Attempt to parse and authenticate the user using the token
            $user = JWTAuth::authenticate($token);
            
            // Check if authentication is successful (user was found)
            if (!$user) {
                return response()->json(['status' => 'User not found'], 404);
            }

            // Optionally, you can check the payload of the token
            $roles = JWTAuth::getPayload()->get('roles');
            $permissions = JWTAuth::getPayload()->get('permissions');
            
            // If necessary, attach the roles and permissions to the request for later use
            $request->merge(['roles' => $roles, 'permissions' => $permissions]);

        } catch (JWTException $e) {
            // Handle different JWT exceptions
            if ($e instanceof \Tymon\JWTAuth\Exceptions\TokenInvalidException) {
                return response()->json(['status' => 'Token is Invalid'], 401);
            } elseif ($e instanceof \Tymon\JWTAuth\Exceptions\TokenExpiredException) {
                return response()->json(['status' => 'Token is Expired'], 401);
            } else {
                return response()->json(['status' => 'Token not found'], 401);
            }
        }

        return $next($request);
    }

}
