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

class AdminController extends Controller {

    public function __construct() {
        
        $this->middleware('authrole');

    }

    public function create(Request $request, User $user) {
    
            try {

            $this->validate($request, [
                'name' => 'required',
                'email' => 'required|email|unique:users',
                'password' => 'required'
            ]);

            $pass = $request->input('password');

            $user->name = $request->input('name');
            $user->email = $request->input('email');
            $user->password = app('hash')->make($pass);
            $user->save();
            
            $roles=Roles::where('role_name', 'employee')->first();
            $id = $roles->id;
            $user->roles()->attach($id); 

            return response()->json(['message' => "Wellcome $user->name!"]);
            
            } catch (\Exception $e) {

            return response()->json(['message' => $e->getMessage()]);
        }
    }
    
    
    public function delete($id) {

        try {
            $user = User::find($id);
            $name = $user->name;

            User::destroy($id);

            return response()->json(['message' => "$name is deleted"]);
            
        } catch (\Exception $e) {

            return response()->json(['message' => 'User with this ID does not exist!']);
        }
    }
    
    
    public function update($id, Request $request) {
        
        try {
            $user = User::find($id);
            
            if ($user == null)
            {return response()->json(['Message'=> 'User with this ID does not exist!']);}
                  
            $user->update($request->all());

            return response()->json(['message' => 'Updated successfully!']);
            
        } catch (\Exception $e) {

            return response()->json(['message' => $e->getMessage()]);
        }
    }
    
    public function changestatus($id, Request $request){
        
        try{
            $user= User::find($id);
            
            if($user == null)
            {return response()->json(['Message'=> 'User with this ID does not exist!']);}
            
            $role =$user->roles()->first();
            $rolename = $role->role_name;
            
            $user_role=Roles::where('role_name', $rolename)->first();
            $id=$user_role->id;
            
            $user_not_role=Roles::whereNotin('role_name', [$rolename])->first();
            $not_id=$user_not_role->id;
            
            $user->roles()->detach($id);
            $user->roles()->attach($not_id);

        } catch (\Exception $e) {

            return response()->json(['message' => $e->getMessage()]);
        }

            return response()->json(['Message'=>"User is not anymore $rolename"]);
    }
    
    
}
