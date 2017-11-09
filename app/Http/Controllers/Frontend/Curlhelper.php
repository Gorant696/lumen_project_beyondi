<?php

namespace App\Http\Controllers\Frontend;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class Curlhelper extends Controller {

    protected $baseurl = 'http://beyondi.loc/';
    

    protected function curlfunc($data) {

        $file = storage_path("tokens/token.txt");
        $content = file_get_contents($file);
        $curl = curl_init();

        curl_setopt($curl, CURLOPT_HTTPHEADER, array(
            "Authorization: Bearer $content",
        ));

        curl_setopt_array($curl, $data);

        $decoded = json_decode(curl_exec($curl));

        curl_close($curl);

        return $decoded;
    }

    protected function get_curl($url) {

        $data = array(
            CURLOPT_URL => "$this->baseurl$url",
            CURLOPT_RETURNTRANSFER => 1,
        );

        return $this->curlfunc($data);
    }

    protected function post_curl($url, $data) {

        $data = array(
            CURLOPT_URL => "$this->baseurl$url",
            CURLOPT_POST => 1,
            CURLOPT_RETURNTRANSFER => 1,
            CURLOPT_POSTFIELDS => $data,
        );

        return $this->curlfunc($data);
    }

    protected function put_curl($url, $id, $data) {


        $data = array(
            CURLOPT_URL => "$this->baseurl$url/$id",
            CURLOPT_RETURNTRANSFER => 1,
            CURLOPT_CUSTOMREQUEST => 'PUT',
            CURLOPT_POSTFIELDS => http_build_query($data)
        );

        return $this->curlfunc($data);
    }

    protected function delete_curl($url, $id) {

       $data= array(
            CURLOPT_URL => "$this->baseurl$url/$id",
            CURLOPT_RETURNTRANSFER => 1,
           CURLOPT_CUSTOMREQUEST => 'DELETE',
        );

      return $this->curlfunc($data);
    }

}
