<?php

namespace App\Http\Controllers\Frontend;

use Illuminate\Http\Request;
use App\User;
use JWTAuth;
use App\Http\Controllers\Controller;

class AuthController extends Controller {

   
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct() {
        
    }
    
    private function get_curl($url){
        
        $file = storage_path("tokens/token.txt");
        $content = file_get_contents($file);

        $curl = curl_init();

        curl_setopt_array($curl, array(
            CURLOPT_URL => "http://beyondi.loc/$url",
            CURLOPT_RETURNTRANSFER => 1,
        ));
        curl_setopt($curl, CURLOPT_HTTPHEADER, array(
            "Authorization: Bearer $content",
        ));

        $decoded = json_decode(curl_exec($curl));
        
        curl_close($curl);    
        
        return $decoded;
        
    }
    
    private function put_curl($url, $id, $data){
        
                
         $file = storage_path("tokens/token.txt");
        $content = file_get_contents($file);
        
            
        $curl = curl_init();
        
          curl_setopt($curl, CURLOPT_HTTPHEADER, array(
            "Authorization: Bearer $content",
        ));
          
          curl_setopt($curl, CURLOPT_CUSTOMREQUEST, 'PUT');
        
        curl_setopt_array($curl, array(
            CURLOPT_URL => "http://beyondi.loc/$url/$id",
            CURLOPT_RETURNTRANSFER => 1,
            CURLOPT_POSTFIELDS => http_build_query($data)
        ));

        $decoded = json_decode(curl_exec($curl));
        curl_close($curl);
        
        return $decoded;
        
        
    }
    
    public function registeruser(Request $request){
        
        
        $file = storage_path("tokens/token.txt");
        $content = file_get_contents($file);
        
            $curl = curl_init();
            
             curl_setopt($curl, CURLOPT_HTTPHEADER, array(
            "Authorization: Bearer $content",
        ));

        curl_setopt_array($curl, array(
            CURLOPT_URL => 'http://beyondi.loc/users',
            CURLOPT_POST => 1,
            CURLOPT_RETURNTRANSFER => 1,
            CURLOPT_POSTFIELDS => array(
                'email' => $request->input('email'),
                'password' => $request->input('password'),
                'name'=>$request->input('name'),
                'role'=>$request->input('role')
            ),
        ));

        $decoded = json_decode(curl_exec($curl));
        curl_close($curl);

        dd($decoded);

        //neki return s porukom, iskemijat
        
    }

    public function loginUser(Request $request) {

        $curl = curl_init();
        
        curl_setopt_array($curl, array(
            CURLOPT_URL => 'http://beyondi.loc/login',
            CURLOPT_POST => 1,
            CURLOPT_RETURNTRANSFER => 1,
            CURLOPT_POSTFIELDS => array(
                'email' => $request->input('email'),
                'password' => $request->input('password')
            ),
        ));

        $decoded = json_decode(curl_exec($curl));
        curl_close($curl);

        if (isset($decoded->error)) {
            echo $decoded->error;
        } else {
            $file = storage_path("tokens/token.txt");
            file_put_contents($file, $decoded->token);
        }

        //neki return s porukom, iskemijat
    }
    
    public function deleteuser($id){
        
     $file = storage_path("tokens/token.txt");
        $content = file_get_contents($file);
        
            
        $curl = curl_init();
        
          curl_setopt($curl, CURLOPT_HTTPHEADER, array(
            "Authorization: Bearer $content",
        ));
          
          curl_setopt($curl, CURLOPT_CUSTOMREQUEST, 'DELETE');
        
        curl_setopt_array($curl, array(
            CURLOPT_URL => "http://beyondi.loc/users/$id",
            CURLOPT_RETURNTRANSFER => 1,
        ));

        $decoded = json_decode(curl_exec($curl));
        curl_close($curl);
        
        dd($decoded);
        
        
    }
    
    public function edit($id, Request $request) {
        
        $data=array(
                'email' => $request->input('email'),
                'password' => $request->input('password'),
                'name' => $request->input('name')
            );
        
           $decoded = $this->put_curl('users', $id, $data);
            dd($decoded);
       

        //neki return s porukom, iskemijat
        
    }
    
    public function addroletouser($id, Request $request){
        
         $data=array(
                'role' => $request->input('role'),
            );
        
           $decoded = $this->put_curl('addrole', $id, $data);
            dd($decoded);

        //neki return s porukom, iskemijat

    }
    
       public function removerolefromuser($id, Request $request){
           
             $data=array(
                'role' => $request->input('role'),
            );
           
            $decoded = $this->put_curl('removerole', $id, $data);
            dd($decoded);
        
        //neki return s porukom, iskemijat

    }
    

    public function findme() {

        $decoded = $this->get_curl('findme');
        dd($decoded);

        return view('frontend.findme', compact('decoded'));
    }
    
    
    public function findone($id){
        
         $decoded = $this->get_curl("users/$id");
         dd($decoded);

        //retur view (compact decoded), ne zaboraviti makniti dd iznad ovog teksta
        
    }
    
     public function findall() {
         
          $decoded = $this->get_curl('users');
        dd($decoded);

        //retur view (compact decoded), ne zaboraviti makniti dd iznad ovog teksta
         
     }
     
      public function logoutuser() {
         
     $decoded = $this->get_curl('logout');
        dd($decoded);

        //retur view (compact decoded), ne zaboraviti makniti dd iznad ovog teksta
         
     }
     
   

}
