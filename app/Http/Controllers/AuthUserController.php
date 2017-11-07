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
            
            if (!$user)  { 
                return response()->json(['error' => 'Wrong email or password!'], 401);
                }
            
            if (Hash::check($request->password, $user->password)) {
                $roles = $user->roles()->with(['permissions'])->get();
                
                $customclaimsarray=[];

                foreach ($roles as $role){
                    $customclaimsarray[$role->role_key] = $role->permissions->pluck('permission_key')->toArray();               
                }
                                        
               $token = JWTAuth::fromUser($user, ['roles' => $customclaimsarray]);
                
            } else { 
                return response()->json(['error' => 'Wrong email or password!'], 401); 
                
            }
                
            return response()->json(compact('token'));}
    
}
