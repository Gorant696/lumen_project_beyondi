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

                    return response()->json(['You are signed as' => $user]);
        }
        
        
        public function logoutuser(){
            
                if ($token = JWTAuth::gettoken())

                { JWTAuth::invalidate($token);

                 return response()->json(['Message'=>'You have successfully signed out!']);}
        
    }
}
