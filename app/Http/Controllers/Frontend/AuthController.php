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

    public function findme() {


        $file = storage_path("tokens/token.txt");
        $content = file_get_contents($file);


        $curl = curl_init();

        curl_setopt_array($curl, array(
            CURLOPT_URL => 'http://beyondi.loc/findme',
            CURLOPT_RETURNTRANSFER => 1,
        ));
        curl_setopt($curl, CURLOPT_HTTPHEADER, array(
            "Authorization: Bearer $content",
        ));

        $decoded = json_decode(curl_exec($curl));

        curl_close($curl);

       // dd($decoded);

        //retur view (compact decoded), ne zaboraviti makniti dd iznad ovog teksta
        
        return view('frontend.findme', compact('decoded'));
    }
    
    public function findone($id){
        
           $file = storage_path("tokens/token.txt");
        $content = file_get_contents($file);


        $curl = curl_init();

        curl_setopt_array($curl, array(
            CURLOPT_URL => "http://beyondi.loc/users/$id",
            CURLOPT_RETURNTRANSFER => 1,
        ));
        curl_setopt($curl, CURLOPT_HTTPHEADER, array(
            "Authorization: Bearer $content",
        ));

        $decoded = json_decode(curl_exec($curl));

        curl_close($curl);

        dd($decoded);

        //retur view (compact decoded), ne zaboraviti makniti dd iznad ovog teksta
        
    }
    
     public function findall() {
         
             $file = storage_path("tokens/token.txt");
        $content = file_get_contents($file);


        $curl = curl_init();

        curl_setopt_array($curl, array(
            CURLOPT_URL => "http://beyondi.loc/users",
            CURLOPT_RETURNTRANSFER => 1,
        ));
        curl_setopt($curl, CURLOPT_HTTPHEADER, array(
            "Authorization: Bearer $content",
        ));

        $decoded = json_decode(curl_exec($curl));

        curl_close($curl);

        dd($decoded);

        //retur view (compact decoded), ne zaboraviti makniti dd iznad ovog teksta
         
     }
     
      public function logoutuser() {
         
             $file = storage_path("tokens/token.txt");
        $content = file_get_contents($file);


        $curl = curl_init();

        curl_setopt_array($curl, array(
            CURLOPT_URL => "http://beyondi.loc/logout",
            CURLOPT_RETURNTRANSFER => 1,
        ));
        curl_setopt($curl, CURLOPT_HTTPHEADER, array(
            "Authorization: Bearer $content",
        ));

        $decoded = json_decode(curl_exec($curl));

        curl_close($curl);

        dd($decoded);

        //retur view (compact decoded), ne zaboraviti makniti dd iznad ovog teksta
         
     }

}
