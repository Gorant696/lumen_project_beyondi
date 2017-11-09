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
    
    public function registration(){
        
        return view('frontend.registration');
        
    }
    
    public function editUser($id){
        
        $ids=$id;
        
        return view('frontend.edituser', compact('ids'));
        
    }
    
    public function addrole($id){
        
        $ids=$id;
        
        return view('frontend.addrole', compact('ids'));
        
    }
    
      public function removerole($id){
        
        $ids=$id;
        
        return view('frontend.removerole', compact('ids'));
        
    }
    

    
  


}