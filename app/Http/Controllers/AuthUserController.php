<?php

namespace App\Http\Controllers;

use App\Roles;
use App\User;
use App\Permissions;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use JWTAuth;
use Tymon\JWTAuth\Exceptions\JWTException;
use Tymon\JWTAuth\Exceptions\TokenExpiredException as ExpiredExc;
use Tymon\JWTAuth\Exceptions\TokenInvalidException as InvalidExc;
use Tymon\JWTAuth\Exceptions\JWTException as JWTExc;

class AuthUserController extends Controller {


public function index() {
        
            return response()->json(['message'=> "Hello! This API is created in laravel/lumen framework!"]);
        
    }
       
     public function authenticate(Request $request) {

            $this->validate($request, [
                'email' => 'required',
                'password' => 'required'
            ]);
        
            $user = User::where('email', $request->input('email'))->first();
            
            if ($user == null)              
            { return response()->json(['error' => 'Wrong email or password!'], 401); }
            
            if (Hash::check($request->password, $user->password)) {

                $role = $user->roles()->get();
                
               $permission_array = [];
             
               $customclaimsarray=[];
              
                
                foreach ($role as $rolename){
                    
                                      
                     $role_permission = Roles::with('permissions')->where('name', $rolename->name)->get();

                     foreach ($role_permission as $permission_name){
                         
                         foreach($permission_name->permissions as $permission){
                         
                            array_push($permission_array, $permission->name);
                         
                         }
                     
                   
                        array_push($customclaimsarray, [$rolename->name=>$permission_array]);
                        $permission_array = [];
                     

                    }
                }
                
              
                             
               $token = JWTAuth::fromUser($user, $customclaimsarray);
                
            } else { return response()->json(['error' => 'Wrong email or password!'], 401); }
                
            return response()->json(compact('token'));}
    
}
