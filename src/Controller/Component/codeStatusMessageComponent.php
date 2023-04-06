<?php

namespace App\Controller\Component;
use Cake\Controller\Component;
use Cake\Http\Client;
use Cake\Http\Client\Request as ClientRequest;

class codeStatusMessageComponent extends Component{

public function attStatus($data){
    $statuses = $data['data']['status'];
     if ($statuses === 'DELIVERY_ACK'){
         $statuses = 'delivered';
     }
     if ($statuses === 'READ'){
         $statuses = 'read';
     }


    $idMessage = $data['data']['id'];
    $contato = str_replace('@s.whatsapp.net','',$data['data']['remoteJid']);
    $datatime = $data['data']['datetime'];
    $donoTel = str_replace('@s.whatsapp.net','',$data['data']['owner']);
    $contato2 = $data['data']['remoteJid'];
    $atualizarStatus = array(
        "object" => "whatsapp_business_account",
        "entry" => array(
            array(
                "id" => "$donoTel",
                "changes" => array(
                    array(
                        "value" => array(
                            "messaging_product" => "whatsapp",
                            "metadata" => array(
                                "display_phone_number" => "$donoTel",
                                "phone_number_id" => "$donoTel"
                            ),
                            "messages" => array(),
                            "contacts" => array(
                                array(
                                    "profile" => array(
                                        "name" => "+".$contato
                                    ),
                                    "wa_id" => "$contato"
                                )
                            ),
                            "statuses" => array(
                                array(
                                    "conversation" => array(
                                        "id" => "$contato2"
                                    ),
                                    "id" => "$idMessage",
                                    "recipient_id" => "$donoTel",
                                    "status" => "$statuses",
                                    "timestamp" => $datatime
                                )
                            ),
                            "errors" => array()
                        ),
                        "field" => "messages"
                    )
                )
            )
        )
    );


    $http = new Client([
        'headers' => ['Content-Type' => 'application/json']
    ]);
    $http->post(
        env('FULL_HOST_CHATWOOT').'/webhooks/whatsapp/+'.$donoTel,
        json_encode($atualizarStatus),
        ['type' => 'json']
    );


}











}
