<?php

namespace App\Controller\Component;

use Cake\Controller\Component;
use Cake\Http\Client;


class mediaDownloadComponent extends Component{
    public function getBASE64($id,$instance,$api = null){

        $curl = curl_init();
        curl_setopt_array($curl, array(
            CURLOPT_URL => env('FULL_HOST_WHATS').'/chat/getBase64FromMediaMessage/'.$instance,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'POST',
            CURLOPT_SSL_VERIFYPEER => false,
            CURLOPT_POSTFIELDS =>'
{
  "key": {
    "id": "'.$id.'"
  }
}',
            CURLOPT_HTTPHEADER => array(
                'apikey: '.$api,
                'Content-Type: application/json'
            ),
        ));
        $response = curl_exec($curl);
        curl_close($curl);
        $response = json_decode($response);
        return $response;
    }

    public function getURL($id,$instance, $api = null){
        $http = new Client([
            'headers' => ['apikey' => $api ?? env('API_KEY_WHATS'), 'Content-Type' => 'application/json']
        ]);
        $search = array(
            "where" => array(
                "key" => array(
                    "id" => $id
                )
            ),
            "limit" => 1
        );
        $resposta = $http->post(
            env('FULL_HOST_WHATS').'/chat/findMessages/'.$instance,
            json_encode($search),
            ['type' => 'json']
        );
        $resposta = $resposta->getJson();
        $resposta = $resposta[0]['message'];
        switch(true) {
            case isset($resposta['documentMessage']):
                $mimetype = $resposta['documentMessage']['mimetype'];
                $sha256 = $resposta['documentMessage']['fileSha256'];
                $file_size = $resposta['documentMessage']['fileLength'];
                break;
            case isset($resposta['videoMessage']):
                $mimetype = $resposta['videoMessage']['mimetype'];
                $sha256 = $resposta['videoMessage']['fileSha256'];
                $file_size = $resposta['videoMessage']['fileLength'];
                break;
            case isset($resposta['imageMessage']):
            case isset($resposta['stickerMessage']):
                if (array_key_exists('imageMessage', $resposta)){
                    $mimetype = $resposta['imageMessage']['mimetype'];
                    $sha256 = $resposta['imageMessage']['fileSha256'];
                    $file_size = $resposta['imageMessage']['fileLength'];
                }else{
                    $mimetype = $resposta['stickerMessage']['mimetype'];
                    $sha256 = $resposta['stickerMessage']['fileSha256'];
                    $file_size = $resposta['stickerMessage']['fileLength'];
                }
                break;
            case isset($resposta['audioMessage']):
                $mimetype = $resposta['audioMessage']['mimetype'];
                $sha256 = $resposta['audioMessage']['fileSha256'];
                $file_size = $resposta['audioMessage']['fileLength'];
                break;
            default:
                // Lógica para mensagem desconhecida
                $sha256 = null;
                $mimetype = null;
        }
        $array = array(
            "messaging_product" => "whatsapp",
            "url" => env('HOSTNAMEDEFAULT').'/downloadmedia/ZXN0ZSBzb2Z0d2FyZSBmb2kgZGVzZW52b2x2aWRvIHBvciBzaXJ0b25ow6NvLCBjYXNvIHF1ZWlyYSBlbnRyYXIgZW0gY29udGF0byBwb2RlIHV0aWxpemFyIGRvIGxpbmtlZGluIGRvIG1lc21vOiBodHRwczovL3d3dy5saW5rZWRpbi5jb20vaW4vbWFyY29zYXNuZXZlcy8=/'.$id,
            "mime_type" => $mimetype,
            "sha256" => $sha256,
            "file_size" => $file_size,
            "id" => $id
        );
        $array = json_encode($array);
        return $array;
    }
}
