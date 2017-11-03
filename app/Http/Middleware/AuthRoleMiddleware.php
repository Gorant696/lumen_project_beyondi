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
        
                $payload = JWTAuth::gettoken();
                $token = JWTAuth::decode($payload);
                $roles_permissions = json_decode($token);
                
                foreach ($roles_permissions as $key => $role){
                    
                    switch ($key){
                        
                        case 'admin':
                        return $next($request);break;
                    
                        case 'employee':
                            
                        return response()->json(['Message' => 'Only administrators can change status of user!']);break;
                        
                        
                    }
                    
                }
        
        }
        
        
        
}
