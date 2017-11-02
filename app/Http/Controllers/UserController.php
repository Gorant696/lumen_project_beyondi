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

class UserController extends Controller {

    public function __construct() {
        
    }
    
    
    public function index() {
        
        return response()->json(['Wellcome message'=> "Hello! This API is created in laravel/lumen framework!"]);
        
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

                $role = $user->roles()->first();
                $rolename= $role->role_name;
                
                $permission_array = [];
                
                $role_permission = Roles::with('permissions')->where('role_name', $rolename)->first();

                foreach ($role_permission->permissions as $permission)
                {array_push($permission_array, $permission->permission_name);}

                $roles_and_permissions = [$rolename=>$permission_array];
                
                $token = JWTAuth::fromUser($user, $roles_and_permissions);
            } else { return response()->json(['error' => 'Wrong email or password!'], 401); }
                
            return response()->json(compact('token'));}
            

    public function findall() {

                $users = User::all();

                return response()->json(['users' => $users]);
    }

    
    public function findone($id) {

                $user=User::find($id);
            
                if ($user == null)
                { return response()->json(['Message' =>'User with this id does not exist']);}
            
                return response()->json(['user' => $user]);
        }
        
        
    

}
