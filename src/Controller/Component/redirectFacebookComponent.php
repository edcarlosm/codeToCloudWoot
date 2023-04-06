<?php
namespace App\Controller\Component;

use Cake\Controller\Component;
use Cake\Http\Client;





class redirectFacebookComponent extends Component{

    function url(){
    return 'https://graph.facebook.com';
    }


    public function mediamessage($url,$bearer){

        $curl = curl_init();
        curl_setopt_array($curl, array(
            CURLOPT_URL => $this->url().$url,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'GET',
            CURLOPT_HTTPHEADER => array(
                'Authorization: Bearer '.$bearer
            ),
        ));
        $response = curl_exec($curl);

        curl_close($curl);
        return $response;



    }

    public function message( $json,$url,$metodo,$token){

        if ($metodo == 'post'){

            $curl = curl_init();

            curl_setopt_array($curl, array(
                CURLOPT_URL => $this->url().$url,
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_ENCODING => '',
                CURLOPT_MAXREDIRS => 10,
                CURLOPT_TIMEOUT => 0,
                CURLOPT_FOLLOWLOCATION => true,
                CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                CURLOPT_CUSTOMREQUEST => 'POST',
                CURLOPT_POSTFIELDS => $json,
                CURLOPT_HTTPHEADER => array(
                    'Authorization: Bearer '.$token,
                    'Content-Type: application/json'
                ),
            ));
            $response = curl_exec($curl);
            curl_close($curl);
            return $response;
        }

    }


    public function getTemplate($url){
        $http = new Client([
            'headers' => ['Content-Type' => 'application/json']
        ]);
        $http = $http->get($this->url().$url);
         return $http->getJson();
    }



}
