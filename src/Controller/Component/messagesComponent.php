<?php
namespace App\Controller\Component;

use Cake\Controller\Component;
use Cake\Datasource\FactoryLocator;
use Sabre\VObject;

class messagesComponent extends Component



{

    public function convertLocation($instancia,$numeroFrom,$idMessage,$nomeContact,$timeStamp, $logitude, $latitude)
    {

        $whatsapp = FactoryLocator::get('Table')->get('Whatsapps'); //loadDB
        $api = $whatsapp->find('all')->where(['instancia' => $instancia])->first();

        $array = array(
            "object" => "whatsapp_business_account",
            "entry" => array(
                array(
                    "id" => $api->id_contanegocios_api,
                    "changes" => array(
                        array(
                            "value" => array(
                                "messaging_product" => "whatsapp",
                                "metadata" => array(
                                    "display_phone_number" => str_replace('+','',$api->numero_telefone),
                                    "phone_number_id" => $api->id_telefone
                                ),
                                "contacts" => array(
                                    array(
                                        "profile" => array(
                                            "name" => "$nomeContact"
                                        ),
                                        "wa_id" => str_replace('@s.whatsapp.net','',$numeroFrom)
                                    )
                                ),
                                "messages" => array(
                                    array(
                                        "from" => str_replace('@s.whatsapp.net','',$numeroFrom),
                                        "id" => "$idMessage",
                                        "timestamp" => $timeStamp,
                                        "location" => array(
                                            "latitude" => $latitude,
                                            "longitude" => $logitude
                                        ),
                                        "type" => "location"
                                    )
                                )
                            ),
                            "field" => "messages"
                        )
                    )
                )
            )
        );
        $array = json_encode($array);
        return $array;


    }

    public function contactConvert($instancia,$numeroFrom,$idMessage,$nomeContact,$timeStamp, $vCard){

        $vcard = VObject\Reader::read($vCard);
        $name = (string) $vcard->N;
        $phoneNumber = (string) $vcard->TEL;

        $whatsapp = FactoryLocator::get('Table')->get('Whatsapps'); //loadDB
        $api = $whatsapp->find('all')->where(['instancia' => $instancia])->first();

        $array = array(
            "object" => "whatsapp_business_account",
            "entry" => array(
                array(
                    "id" => $api->id_contanegocios_api,
                    "changes" => array(
                        array(
                            "value" => array(
                                "messaging_product" => "whatsapp",
                                "metadata" => array(
                                    "display_phone_number" => str_replace('+','',$api->numero_telefone),
                                    "phone_number_id" => $api->id_telefone
                                ),
                                "messages" => array(
                                    array(
                                        "from" => str_replace('@s.whatsapp.net','',$numeroFrom),
                                        "id" => "$idMessage",
                                        "timestamp" => $timeStamp,
                                        "contacts" => array(
                                            array(
                                                "name" => array(
                                                    "formatted_name" => "$name"
                                                ),
                                                "phones" => array(
                                                    array(
                                                        "phone" => "$phoneNumber"
                                                    )
                                                )
                                            )
                                        ),
                                        "type" => "contacts"
                                    )
                                ),
                                "contacts" => array(
                                    array(
                                        "profile" => array(
                                            "name" => "$nomeContact"
                                        ),
                                        "wa_id" => str_replace('@s.whatsapp.net','',$numeroFrom)
                                    )
                                ),
                                "statuses" => array(),
                                "errors" => array()
                            ),
                            "field" => "messages"
                        )
                    )
                )
            )
        );

        $array = json_encode($array);
        return $array;

    }

    public function convertText($instancia,$numeroFrom,$idMessage,$nomeContact,$timeStamp, $msg, $quotedMsg = null){
        $whatsapp = FactoryLocator::get('Table')->get('Whatsapps'); //loadDB
        $api = $whatsapp->find('all')->where(['instancia' => $instancia])->first();

        if ($quotedMsg){
            $msg = "***$quotedMsg***\n\n $msg";
        }

        $data = array(
            "object" => "whatsapp_business_account",
            "entry" => array(
                array(
                    "id" => $api->id_contanegocios_api,
                    "changes" => array(
                        array(
                            "value" => array(
                                "messaging_product" => "whatsapp",
                                "metadata" => array(
                                    "display_phone_number" => str_replace('+','',$api->numero_telefone),
                                    "phone_number_id" => $api->id_telefone
                                ),
                                "contacts" => array(
                                    array(
                                        "profile" => array(
                                            "name" => "$nomeContact"
                                        ),
                                        "wa_id" => str_replace('@s.whatsapp.net','',$numeroFrom)
                                    )
                                ),
                                "messages" => array(
                                    array(
                                        "from" => str_replace('@s.whatsapp.net','',$numeroFrom),
                                        "id" => "$idMessage",
                                        "timestamp" => $timeStamp,
                                        "text" => array(
                                            "body" => "$msg"
                                        ),
                                        "type" => "text"
                                    )
                                )
                            ),
                            "field" => "messages"
                        )
                    )
                )
            )
        );

        $data = json_encode($data);
        return $data;

    }

    public function convertMedia($instancia,$data){

        $message = $data['data']['message'];

        $whatsapp = FactoryLocator::get('Table')->get('Whatsapps'); //loadDB
        $api = $whatsapp->find('all')->where(['instancia' => $instancia])->first();

        switch(true) {
            case isset($message['documentMessage']):
                $media = 'document';
                $mimetype = $message['documentMessage']['mimetype'];
                $sha256 = $message['documentMessage']['fileSha256'];
                if (array_key_exists('caption', $message['documentMessage'])){
                    $caption =  $message['documentMessage']['caption'];
                }else{
                    $caption = null;
                }
                $url = $message['documentMessage']['url'];
                break;
            case isset($message['videoMessage']):
                $media = 'video';
                $mimetype = $message['videoMessage']['mimetype'];
                $sha256 = $message['videoMessage']['fileSha256'];
                if (array_key_exists('caption', $message['videoMessage'])){
                    $caption =  $message['videoMessage']['caption'];
                }else{
                    $caption = null;
                }
                $url = $message['videoMessage']['url'];
                break;
            case isset($message['imageMessage']):
            case isset($message['stickerMessage']):

                if (array_key_exists('imageMessage',$message)){
                    $mimetype = $message['imageMessage']['mimetype'];
                    $sha256 = $message['imageMessage']['fileSha256'];

                    if (array_key_exists('caption', $message['imageMessage'])){
                        $caption =  $message['imageMessage']['caption'];
                    }else{
                        $caption = null;
                    }
                    $url = $message['imageMessage']['url'];
                }else{
                    $mimetype = $message['stickerMessage']['mimetype'];
                    $sha256 = $message['stickerMessage']['fileSha256'];
                    if (array_key_exists('caption', $message['stickerMessage'])){
                        $caption =  $message['stickerMessage']['caption'];
                    }else{
                        $caption = null;
                    }
                    $url = $message['stickerMessage']['url'];
                }
                $media = 'image';
                break;
            case isset($message['audioMessage']):
                $media = 'audio';
                $mimetype = $message['audioMessage']['mimetype'];
                $sha256 = $message['audioMessage']['fileSha256'];
                if (array_key_exists('caption', $message['audioMessage'])){
                    $caption =  $message['audioMessage']['caption'];
                }else{
                    $caption = null;
                }
                $url = $message['audioMessage']['url'];
                break;
            default:
                // Lógica para mensagem desconhecida
                $media = null;
                $url = null;
                $caption = null;
                $sha256 = null;
                $mimetype = null;
        }

        $array = array(
            "object" => "whatsapp_business_account",
            "entry" => array(
                array(
                    "id" => $api->id_contanegocios_api,
                    "changes" => array(
                        array(
                            "value" => array(
                                "messaging_product" => "whatsapp",
                                "metadata" => array(
                                    "display_phone_number" => str_replace('+','',$api->numero_telefone),
                                    "phone_number_id" => $api->id_telefone
                                ),
                                "messages" => array(
                                    array(
                                        "from" => str_replace('@s.whatsapp.net','',$data['data']['key']['remoteJid']),
                                        "id" => $data['data']['key']['id'],
                                        "timestamp" => $data['data']['messageTimestamp'],
                                        "$media" => array(
                                            "caption" => $caption,
                                            "filename" => $data['data']['key']['id'],
                                            "mime_type" => "$mimetype",
                                            "sha256" => $sha256,
                                           // "url" => $url,
                                            "id" => $data['data']['key']['id']
                                        ),
                                        "type" => "$media"
                                    )
                                ),
                                "contacts" => array(
                                    array(
                                        "profile" => array(
                                            "name" => $data['data']['pushName']
                                        ),
                                        "wa_id" => str_replace('@s.whatsapp.net','',$data['data']['key']['remoteJid'])
                                    )
                                ),
                                "statuses" => array(),
                                "errors" => array()
                            ),
                            "field" => "messages"
                        )
                    )
                )
            )
        );

        return json_encode($array);




    }



}
