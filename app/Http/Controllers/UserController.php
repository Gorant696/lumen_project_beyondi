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

                $this->middleware('authrole');

         }
    

            public function create(Request $request, User $user) {
    
          
                $this->validate($request, [
                    'name' => 'required',
                    'email' => 'required|email|unique:users',
                    'password' => 'required'
                ]);
            
            try {
                $pass = $request->input('password');

                $user->name = $request->input('name');
                $user->email = $request->input('email');
                $user->password = app('hash')->make($pass);
                $user->save();

                $roles=Roles::where('key', 'employee')->first();
                $id = $roles->id;
                $user->roles()->attach($id); 

                return response()->json(['message' => "Wellcome $user->name!"]);
            
            } catch (\Exception $e) {

            return response()->json(['message' => 'You need to provide name, email and password!']);
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
                
                 $this->validate($request, [
                    'name' => 'required',
                    'email' => 'required|email|unique:users',
                    'password' => 'required'
                ]);

                try {
                    $user = User::find($id);

                    if ($user == null)
                    {return response()->json(['message'=> 'User with this ID does not exist!']);}

                  
                    $pass = $request->input('password');

                    $user->name = $request->input('name');
                    $user->email = $request->input('email');
                    $user->password = app('hash')->make($pass);
                    $user->save();

                //  $user->update($request->all());

                    return response()->json(['message' => 'Updated successfully!']);

                } catch (\Exception $e) {

                    return response()->json(['message' => $e->getMessage()]);
                }
            }
    
            public function changestatus($id, Request $request) {

                try{
                    $user= User::find($id);

                    if (!$user) {
                        return response()->json(['message'=> 'User with this ID does not exist!']);
                    }

                    $role =$user->roles()->first();
                    $rolename = $role->key;

                    $user_role=Roles::where('key', $rolename)->first();
                    $id=$user_role->id;

                    $user_not_role=Roles::whereNotin('key', [$rolename])->first();
                    $not_id=$user_not_role->id;

                    $user->roles()->detach($id);
                    $user->roles()->attach($not_id);

                } catch (\Exception $e) {

                    return response()->json(['message' => $e->getMessage()]);
                }

                    return response()->json(['message'=>"User is not anymore $rolename"]);
            }
            

            public function findall(Request $request) {


                        $users = User::all();

                        return response()->json(['users' => $users]);
            }

    
            public function findone($id) {

                        $user=User::find($id);

                        if ($user == null)
                        { return response()->json(['message' =>'User with this id does not exist']);}

                        return response()->json(['user' => $user]);
                }
        
            public function findme() {

               try {

                   if (!$user = JWTAuth::parseToken()->toUser()) {

                       return response()->json(['user_not_found'], 404);}
                   } catch (ExpiredExc $e) {

                       return response()->json(['token_expired'], $e->getStatusCode());
                   } catch (InvalidExc $e) {

                       return response()->json(['token_invalid'], $e->getStatusCode());
                   } catch (JWTExc$e) {

                       return response()->json(['token_absent'], $e->getStatusCode());
                   }

                   $token = JWTAuth::gettoken();
                   
                   $payload = JWTAuth::decode($token);
                   
                   $roles_permissions = json_decode($payload);

                   return response()->json(['signed as' => $user, 'Roles and Permissions'=>$roles_permissions]);
           }
        
        
            public function logoutuser(){

                    if ($token = JWTAuth::gettoken())

                    { JWTAuth::invalidate($token);

                     return response()->json(['message'=>'You have successfully signed out!']);}

        }
        
    
}
