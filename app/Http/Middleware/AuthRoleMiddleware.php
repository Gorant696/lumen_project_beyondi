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
        
        
             $data = $request->route();
             
                 foreach ($data as $key =>$datas) {
                     
                     //pitat jel bolje key==1 ili funkcija koja traži određeni dio stringa(Controller) u $datasu
                         
                         if ($key == 1) {
                             
                            $string = explode("@", $datas['uses']);
                            
                           $method=$string[1];
                             
                         }
                     }
                                        
             $token = JWTAuth::gettoken();
             
             $payload = JWTAuth::decode($token);
             
             $roles_permissions = json_decode($payload);
             
        try{
             
             foreach ($roles_permissions as $object){

                foreach ($object as $key => $role){

                     switch ($key){
                        
                         case 'admin':
                           
                         return $next($request); break;
                    
                    
                         case 'employee': case 'editor':    
                            
                            foreach ($role as $role_permit) {
                         
                                if( $role_permit == $method){
                             
                                return $next($request);
                             
                            }
                         
                            } break; 
                    }
                }
             }
               } catch(\Exception $e){
                   
                   return response()->json(['message' => 'You are not allowed to access this method!']); 
                   
               }

        }
  
}
