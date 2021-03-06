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
            'password' => 'required',
            'role' => 'required'
        ]);

        try {
            $pass = $request->input('password');

            $user->name = $request->input('name');
            $user->email = $request->input('email');
            $user->password = app('hash')->make($pass);
            $user->save();

            $roles = Roles::where('role_key', $request->input('role'))->first();
            $user->roles()->attach($roles->id);

            return response()->json(['message' => "Wellcome $user->name!"]);
        } catch (\Exception $e) {

            return response()->json(['message' => 'You need to provide name, email, password and role!']);
        }
    }

    public function delete($id) {

        try {
            $user = User::find($id);

            User::destroy($id);

            return response()->json(['message' => "$user->name is deleted"]);
        } catch (\Exception $e) {

            return response()->json(['message' => "Can't delete user!"]);
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

            if (!$user) {
                return response()->json(['message' => 'User with this ID does not exist!']);
            }


            $pass = $request->input('password');

            $user->name = $request->input('name');
            $user->email = $request->input('email');
            $user->password = app('hash')->make($pass);
            $user->save();


            return response()->json(['message' => 'Updated successfully!']);
        } catch (\Exception $e) {

            return response()->json(['message' => $e->getMessage()]);
        }
    }

    public function addrole($id, Request $request, Roles $roles) {

        $this->validate($request, [
            'role' => 'required'
        ]);

        try {
            $user = User::find($id);

            if (!$user) {
                return response()->json(['message' => 'User with this ID does not exist!']);
            }

            $roleid = $roles->where('role_key', $request->input('role'))->first();

            if ($user->roles()->where('role_key', $roleid->role_key)->first()) {

                return response()->json(['message' => "Role is already attached to user!"]);
            }

            $user->roles()->attach($roleid->id);
            
        } catch (\Exception $e) {

            return response()->json(['message' => 'Input role data is invalid!']);
        }

        return response()->json(['message' => "Role added successfully"]);
    }

    public function removerole($id, Request $request, Roles $roles) {

        $this->validate($request, [
            'role' => 'required'
        ]);

        try {
            $user = User::find($id);

            if (!$user) {
                return response()->json(['message' => 'User with this ID does not exist!']);
            }

            $roleid = $roles->where('role_key', $request->input('role'))->first();

            if (!$user->roles()->where('role_key', $roleid->role_key)->first()) {

                return response()->json(['message' => "User does not have current role!"]);
            }

            $user->roles()->detach($roleid->id);
        } catch (\Exception $e) {

            return response()->json(['message' => 'Input role data is invalid!']);
        }

        return response()->json(['message' => "Role removed successfully"]);
    }

    public function findall(Request $request) {


        $users = User::all();

        return response()->json(['users' => $users]);
    }

    public function findone($id) {

        $user = User::find($id);

        if (!$user) {
            return response()->json(['message' => 'User with this id does not exist']);
        }

        return response()->json(['user' => $user]);
    }

    public function findme() {

        try {

            if (!$user = JWTAuth::parseToken()->toUser()) {

                return response()->json(['user_not_found'], 404);
            }
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
        

        return response()->json(['signed_as' => $user, 'roles_and_permissions' => $roles_permissions]);
    }

    public function logoutuser() {

        if ($token = JWTAuth::gettoken()) {
            JWTAuth::invalidate($token);

            return response()->json(['message' => 'You have successfully signed out!']);
        }
    }

}
