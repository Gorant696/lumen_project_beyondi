<?php

namespace App\Http\Controllers\Frontend;


use App\User;
use App\Http\Controllers\Controller;

class ViewController extends Controller {

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct() {

     
    }

    public function welcome(){
        
        return view('frontend.login');
        
    }
    
    public function registeruser(){
        
        
        
    }


}