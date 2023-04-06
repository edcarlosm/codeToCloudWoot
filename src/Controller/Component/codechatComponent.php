<?php

namespace App\Controller\Component;
use Cake\Controller\Component;
use Cake\Http\Client;
use Cake\Http\Client\Request as ClientRequest;



class codechatComponent extends Component
{

    function formateNumber($number){
        return str_replace("+", "", $number);
    }

    public function sendDocument($accessToken,$number,$link,$instance, $filename, $caption = null){

        $http = new Client([
            'headers' => ['apikey' => $accessToken]
        ]);


        $data = array(
            "number" => "$number",
            "options" => array(
                "delay" => 500
            ),
            "mediaMessage" => array(
                "mediatype" => "document",
                "fileName" => "$filename",
                "caption" => "$caption",
                "media" => "$link"
            )
        );

        $response = $http->post(
            env('FULL_HOST_WHATS').'/message/sendMedia/'.$instance,
            json_encode($data),
            ['type' => 'json']
        );
        $retorno = $response->getJson();
        $ret = array(
            "messaging_product" => "whatsapp",
            "contacts" => array(
                array("wa_id" => "$number")
            ),
            "messages" => array(
                array("id" => $retorno['key']['id'])
            )
        );
        return json_encode($ret);


    }
    public function sendVideo($accessToken,$number,$link,$instance, $caption = null){
        $http = new Client([
            'headers' => ['apikey' => $accessToken]
        ]);

        $data = array(
            "number" => "$number",
            "options" => array(
                "delay" => 500
            ),
            "mediaMessage" => array(
                "mediatype" => "video",
                "fileName" => "video.mp4",
                "caption" => "$caption",
                "media" => "$link"
            )
        );

        $response = $http->post(
            env('FULL_HOST_WHATS').'/message/sendMedia/'.$instance,
            json_encode($data),
            ['type' => 'json']
        );
        $retorno = $response->getJson();
        $ret = array(
            "messaging_product" => "whatsapp",
            "contacts" => array(
                array("wa_id" => "$number")
            ),
            "messages" => array(
                array("id" => $retorno['key']['id'])
            )
        );
        return json_encode($ret);


    }

    public function sendImage($accessToken,$number,$link,$instance, $caption = null){
        $http = new Client([
            'headers' => ['apikey' => $accessToken]
        ]);

        $data = array(
            "number" => "$number",
            "options" => array(
                "delay" => 500
            ),
            "mediaMessage" => array(
                "mediatype" => "image",
                "fileName" => "image.png",
                "caption" => "$caption",
                "media" => "$link"
            )
        );

        $response = $http->post(
            env('FULL_HOST_WHATS').'/message/sendMedia/'.$instance,
            json_encode($data),
            ['type' => 'json']
        );
        $retorno = $response->getJson();
        $ret = array(
            "messaging_product" => "whatsapp",
            "contacts" => array(
                array("wa_id" => "$number")
            ),
            "messages" => array(
                array("id" => $retorno['key']['id'])
            )
        );
        return json_encode($ret);


    }
    public function sendAudio($accessToken,$number,$link,$instance){

        $http = new Client([
            'headers' => ['apikey' => $accessToken]
        ]);

        $data = array(
            "number" => "$number",
            "options" => array(
                "delay" => 1200
            ),
            "audioMessage" => array(
                "audio" => "$link"
            )
        );

        $response = $http->post(
            env('FULL_HOST_WHATS').'/message/sendWhatsAppAudio/'.$instance,
            json_encode($data),
            ['type' => 'json']
        );
        $retorno = $response->getJson();
        $ret = array(
            "messaging_product" => "whatsapp",
            "contacts" => array(
                array("wa_id" => "$number")
            ),
            "messages" => array(
                array("id" => $retorno['key']['id'])
            )
        );
        return json_encode($ret);

    }
    public function enviarText($accessToken, $number, $msg, $instance)
    {
       // $number = $this->formateNumber($number);

        $http = new Client([
            'headers' => ['apikey' => $accessToken]
        ]);
        $data = array('number' => $number, 'options' => array('delay' => 1200), 'textMessage' => array('text' => $msg));
       // return json_encode($data);
        $response = $http->post(
            env('FULL_HOST_WHATS').'/message/sendText/'.$instance,
            json_encode($data),
            ['type' => 'json']
        );
        $retorno = $response->getJson();
        $ret = array(
            "messaging_product" => "whatsapp",
            "contacts" => array(
                array("wa_id" => "$number")
            ),
            "messages" => array(
                array("id" => $retorno['key']['id'])
            )
        );
        return json_encode($ret);
    }

}
