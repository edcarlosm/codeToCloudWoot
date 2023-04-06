<?php
namespace App\Controller\Component;

use Cake\Controller\Component;
use Cake\Http\Client;

class messageToChatwootComponent extends Component
{
    function _postData($json, $celphoneregister){

        $http = new Client([
            'headers' => ['Content-Type' => 'application/json']
        ]);
        $http->post(
            env('FULL_HOST_CHATWOOT').'/webhooks/whatsapp/+'.$celphoneregister,
            $json,
            ['type' => 'json']
        );
    }
    public function sendText($data,$donoTel){
        $this->_postData($data,$donoTel);
    }
    public function sendMediaURL($data, $donoTel){
        $this->_postData($data,$donoTel);
    }
    public function sendContact($data,$donoTel){
        $this->_postData($data,$donoTel);
    }
    public function sendLocation($data, $donoTel){
        $this->_postData($data,$donoTel);
    }
}
