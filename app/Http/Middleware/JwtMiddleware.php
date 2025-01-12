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
        try
        {
            $token       = JWTAuth::getToken();
            $payload     = JWTAuth::getPayload($token)->toArray();
            $permissions = $payload['permissions'] ?? [];
            // Map permissions to routes 'route_name' => 'permission_name',
            $permissionMappings = [
                'files.index'   => 'read-file',
                'files.show'    => 'show-file',
                'files.store'   => 'create-file',
                'files.update'  => 'update-file',
                'files.destroy' => 'delete-file',
            ];
            // Get current route name
            $routeName = $request->route()->getName();
            // Check if the current route has a mapped permission
            if (isset($permissionMappings[$routeName]))
            {
                $requiredPermission = $permissionMappings[$routeName];
                // Deny access if the user lacks the required permission
                if (!in_array($requiredPermission, $permissions))
                {
                    return response()->json(['error' => 'You Does Not Have The Right Permissions', 'status' => 403], 403);
                }
            }
        }
        catch (\Tymon\JWTAuth\Exceptions\TokenExpiredException $e)
        {
            return response()->json(['message' => 'Token Is Expired', 'status' => 500], 500);
        }
        catch (\Tymon\JWTAuth\Exceptions\TokenInvalidException $e)
        {
            return response()->json(['message' => 'Token is Invalid', 'status' => 500], 500);
        }
        catch (\Tymon\JWTAuth\Exceptions\JWTException $e)
        {
            return response()->json(['message' =>  $e->getMessage(), 'status' => 500], 500);
        }
        

        return $next($request);
    }

}
