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

    public function authenticate(Request $request) {

            $this->validate($request, [
                'email' => 'required',
                'password' => 'required'
            ]);
        
            //probat optimizirati ovaj kod, pokledat u eloquent dokumentaciji
        try {
            $user = User::where('email', $request->input('email'))->first();

            if (Hash::check($request->password, $user->password)) {

                $role = $user->roles()->first();
                $rolename= $role->role_name;
                
                $permission_array = [];
                
                $role_permission = Roles::with('permissions')->where('role_name', $rolename)->get();
                foreach ($role_permission as $permission)
                {
                    foreach ($permission->permissions as $per)
                    {array_push($permission_array, $per->permission_name);}
                }
                
                $roles_and_permissions = [$rolename=>$permission_array];
                
                $token = JWTAuth::fromUser($user, $roles_and_permissions);
            } else {
                return response()->json(['error' => 'Wrong email or password!'], 401);
            }
        } //endtry
                catch (JWTException $e) {

                return response()->json(['error' => 'Could not proceed!'], 500);
        }

            // vraća token ako je sve u redu
            return response()->json(compact('token'));
    }

    public function findall() {

                $users = User::all();

                return response()->json(['users' => $users]);
    }

    
    public function findone($id) {

        
                $user=User::find($id);
            
                if ($user == null){

                return response()->json(['Message' =>'User with this id does not exist']);
                }
            
                return response()->json(['user' => $user]);
        }
        
        
    

}
