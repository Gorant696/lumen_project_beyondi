<?php

namespace App\Http\Middleware;

use Closure;
use App\User;
use Illuminate\Http\Request;
use App\Roles;
use JWTAuth;
use Tymon\JWTAuth\Exceptions\JWTException;
use Tymon\JWTAuth\Exceptions\TokenExpiredException as ExpiredExc;
use Tymon\JWTAuth\Exceptions\TokenInvalidException as InvalidExc;
use Tymon\JWTAuth\Exceptions\JWTException as JWTExc;


class AuthRoleMiddleware {


    public function handle($request, Closure $next) {
        
            $user = JWTAuth::parseToken()->toUser();
            $role = $user->roles()->first();
            $roles = $role->role_name;

            if ($roles == 'admin') {
                
                return $next($request);
                
            } else { return response()->json(['message' => 'Only admins can acces']);}
        }
}
