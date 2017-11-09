<?php

namespace App\Http\Controllers\Frontend;

use Illuminate\Http\Request;
use App\User;
use JWTAuth;
use App\Http\Controllers\Controller;

class Curlhelper extends Controller  {
    
        
    protected $baseurl='http://beyondi.loc/';
    
    private function curl(){
        
        $file = storage_path("tokens/token.txt");
        $content = file_get_contents($file);
        
        
        
        $curl = curl_init();
        
         curl_setopt($curl, CURLOPT_HTTPHEADER, array(
            "Authorization: Bearer $content",
        ));
         
         
          $decoded = json_decode(curl_exec($curl));

        curl_close($curl);

        return $decoded;

        
    }
    

 
    protected function get_curl($url) {

        $file = storage_path("tokens/token.txt");
        $content = file_get_contents($file);

        $curl = curl_init();
        
         curl_setopt($curl, CURLOPT_HTTPHEADER, array(
            "Authorization: Bearer $content",
        ));

        curl_setopt_array($curl, array(
            CURLOPT_URL => "$this->baseurl$url",
            CURLOPT_RETURNTRANSFER => 1,
        ));
       

        $decoded = json_decode(curl_exec($curl));

        curl_close($curl);

        return $decoded;
    }
    
    protected function post_curl($url, $data){
        
             $file = storage_path("tokens/token.txt");
            $content = file_get_contents($file);
        
            $curl = curl_init();
            
             curl_setopt($curl, CURLOPT_HTTPHEADER, array(
            "Authorization: Bearer $content",
        ));

        curl_setopt_array($curl, array(
            CURLOPT_URL =>"$this->baseurl$url",
            CURLOPT_POST => 1,
            CURLOPT_RETURNTRANSFER => 1,
            CURLOPT_POSTFIELDS => $data,
        ));

        $decoded = json_decode(curl_exec($curl));
        curl_close($curl);

        return $decoded;
        
    }

    protected function put_curl($url, $id, $data) {


        $file = storage_path("tokens/token.txt");
        $content = file_get_contents($file);


        $curl = curl_init();

        curl_setopt($curl, CURLOPT_HTTPHEADER, array(
            "Authorization: Bearer $content",
        ));

        curl_setopt($curl, CURLOPT_CUSTOMREQUEST, 'PUT');

        curl_setopt_array($curl, array(
            CURLOPT_URL => "$this->baseurl$url/$id",
            CURLOPT_RETURNTRANSFER => 1,
            CURLOPT_POSTFIELDS => http_build_query($data)
        ));

        $decoded = json_decode(curl_exec($curl));
        curl_close($curl);

        return $decoded;
    }

    protected function delete_curl($url, $id) {

        $file = storage_path("tokens/token.txt");
        $content = file_get_contents($file);


        $curl = curl_init();

        curl_setopt($curl, CURLOPT_HTTPHEADER, array(
            "Authorization: Bearer $content",
        ));

        curl_setopt($curl, CURLOPT_CUSTOMREQUEST, 'DELETE');

        curl_setopt_array($curl, array(
            CURLOPT_URL => "$this->baseurl$url/$id",
            CURLOPT_RETURNTRANSFER => 1,
        ));

        $decoded = json_decode(curl_exec($curl));
        curl_close($curl);

        return $decoded;
    }

}
