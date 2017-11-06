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


        $route = $request->route();
        $actions = $route[1];

        $token = JWTAuth::gettoken();
        $payload = JWTAuth::decode($token);
        $role_permissions = json_decode($payload);
        $nextRoute = false;
       
        foreach ($role_permissions->roles as $userRole => $userPermissions) {
            
        
             
         // $actions['roles'] = ['admin', 'employee', 'editor'],
            if (in_array($userRole, $actions['roles']) || array_key_exists($userRole, $actions['roles'])) { 
                 
                if(isset($actions['roles'][$userRole])) { //$actions['roles']['admin']
                    foreach($actions['roles'][$userRole] as $permission) {
                        if(in_array($permission, $userPermissions)) {
                            $nextRoute = true;
                        }
                    }
                } else {
                    $nextRoute = true;
                }
            }
        }
        
        if($nextRoute) {
            return $next($request);
        }

        return response()->json(['message' => 'You are not allowed to access this method!']);
        //-----------------------------------------------------------------------------------
        
        //Dolje je način za samo po permissionima, koji bi bili isti kao imena metoda kontrolera, 
        //ali onda ne treba u rutama definirati rolese
        
        /*    foreach ($route as $key =>$datas) {

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

          } */
    }

}
