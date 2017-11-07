<?php


namespace App\Http\Controllers\Frontend;


use App\User;
use App\Http\Controllers\Controller;

class AuthController extends Controller {

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct() {

     
    }

    public function loginUser(){
        
        //return "dobar dan";
        $curl = curl_init('http://localhost:8000/');
        $result = curl_exec($curl);
        curl_close($curl);
        return $result;
    }
    



}