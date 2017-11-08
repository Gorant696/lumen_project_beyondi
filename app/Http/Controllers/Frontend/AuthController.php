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
       $curl = curl_init('http://beyondi.loc/welcome');
//curl_setopt_array($curl, array(
  //  CURLOPT_RETURNTRANSFER => 1,
    //CURLOPT_URL => 'http://localhost:80'
//));
// Send the request & save response to $resp
$resp = curl_exec($curl);
//$result=json_decode($resp);
// Close request to clear up some resources
curl_close($curl);

//return $resp;
    }
    



}