<?php
declare(strict_types=1);
namespace App\Controller;
use Cake\Http\Exception\UnauthorizedException;
use Cake\Routing\Router;
use Exception;


/**
 * ApisController Controller
 *
 * @method \App\Model\Entity\ApisController[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class ApisController extends AppController
{
    public function initialize(): void
    {
        parent::initialize();
        $this->loadComponent('MessageTemplates');
        $this->loadComponent('messages');
        $this->loadComponent('codechat');
        $this->loadComponent('codeStatusMessage');
        $this->loadComponent('messageToChatwoot');
        $this->loadComponent('mediaDownload');
        $this->loadComponent('redirectFacebook');
        $this->loadComponent('codechatServer');


    }

    /**
     * Index method
     *
     * @return \Cake\Http\Response|null|void Renders view
     */



    public function codewebhookcloud(){

        if($this->request->is('post')){
            $data = $this->request->getParsedBody();
            if ($data['event'] == 'messages.update'){
                $this->codeStatusMessage->attStatus($data);
            die();
            }
            $instancia = $data['instance'];
            if ($data['event'] == 'messages.upsert'){
                switch(true) {
                    case array_key_exists('conversation', $data['data']['message']):
                $conversaoJson = $this->messages->convertText($instancia,$data['data']['key']['remoteJid'], $data['data']['key']['id'], $data['data']['pushName'],$data['data']['messageTimestamp'],$data['data']['message']['conversation']);
                        $test = $this->messageToChatwoot->sendText($conversaoJson, str_replace('@s.whatsapp.net','',$data['data']['owner']));
                        die();
                    case array_key_exists('extendedTextMessage', $data['data']['message']):

                        if (array_key_exists('quotedMessage', $data['data']['message']['extendedTextMessage']['contextInfo'])){

                            $conversao = $this->messages->convertText($instancia,$data['data']['key']['remoteJid'], $data['data']['key']['id'], $data['data']['pushName'],$data['data']['messageTimestamp'],$data['data']['message']['extendedTextMessage']['text'],$data['data']['message']['extendedTextMessage']['contextInfo']['quotedMessage']['conversation']);
                            $this->messageToChatwoot->sendText($conversao, str_replace('@s.whatsapp.net','',$data['data']['owner']));
                            die();

                        }
                        $conversao = $this->messages->convertText($instancia,$data['data']['key']['remoteJid'], $data['data']['key']['id'], $data['data']['pushName'],$data['data']['messageTimestamp'],$data['data']['message']['extendedTextMessage']['text']);
                        $this->messageToChatwoot->sendText($conversao, str_replace('@s.whatsapp.net','',$data['data']['owner']));

                        die();

                    case array_key_exists('locationMessage', $data['data']['message']):


                        $jsonCloud = $this->messages->convertLocation($instancia,$data['data']['key']['remoteJid'], $data['data']['key']['id'], $data['data']['pushName'],$data['data']['messageTimestamp'],$data['data']['message']['locationMessage']['degreesLatitude'],$data['data']['message']['locationMessage']['degreesLongitude']);
                        $this->messageToChatwoot->sendLocation($jsonCloud,str_replace('@s.whatsapp.net','',$data['data']['owner']));

                        die();

                    case array_key_exists('contactMessage', $data['data']['message']):

                        $contactJson = $this->messages->contactConvert($instancia,$data['data']['key']['remoteJid'], $data['data']['key']['id'], $data['data']['pushName'],$data['data']['messageTimestamp'],$data['data']['message']['contactMessage']['vcard']);
                        $this->messageToChatwoot->sendContact($contactJson,str_replace('@s.whatsapp.net','',$data['data']['owner']));

                        die();

                    case array_key_exists('imageMessage', $data['data']['message']) || array_key_exists('videoMessage', $data['data']['message']) || array_key_exists('documentMessage', $data['data']['message']) || array_key_exists('stickerMessage', $data['data']['message'])  || array_key_exists('audioMessage', $data['data']['message']):

                        $mediaJson = $this->messages->convertMedia($instancia,$data);
                        $this->messageToChatwoot->sendMediaURL($mediaJson,str_replace('@s.whatsapp.net','',$data['data']['owner']));

                        die();

                    default:
                        echo 'nenhuma opção válida encontrada';
                }
                //fazer um provavel switch para ver o tipo de mensagem e enviar ao chatwoot1



            }



        }




    }


    public function webhookcloudwhatsapp()
    {




    }


    public function index()
    {
        echo 'Developer By SirTonhão';
    }

    function messagetemplate()
    {
        return $this->MessageTemplates->BasicTemplate();
    }


    public function downloadmedia($id){

        $parametros = $this->request->getServerParams();
        $bearerToken = $parametros['HTTP_AUTHORIZATION'];
        $bearerToken = str_replace("Bearer ", '', $bearerToken);
        $zapis = $this->getTableLocator()->get('Whatsapps');
        $number = base64_decode($bearerToken);
        $zapi = $zapis->find('all')->where(['numero_telefone' => $number])->first();
        if ($zapi != null){
            $instancia = $zapi->instancia;
            $api = $zapi->api_key_server;
           $download =  $this->mediaDownload->getBASE64($id,$instancia,$api);

            $ext = explode("/", "$download->mimetype");
            $ext = $ext[1];
            $decoded = base64_decode($download->base64);
            $file = 'file.' . $ext;
            file_put_contents($file, $decoded);
            if (file_exists($file)) {
                header('Content-Description: File Transfer');
                header('Content-Type: ' . $download->mimetype);
                header('Content-Disposition: attachment; filename="' . basename($file) . '"');
                header('Expires: 0');
                header('Cache-Control: must-revalidate');
                header('Pragma: public');
                header('Content-Length: ' . filesize($file));
                readfile($file);
                exit;
            }
        }else{
            throw new UnauthorizedException('ERROR 401');
        }
    }


    public function router($id = null)
    {
        if ($this->request->is('get')) {
            $requestVariable = Router::url(null, false);
            $requestVariable = explode('/', $requestVariable);


            if (isset($requestVariable[3])) {
                $typeReq = $requestVariable[3];
                //First Block contain message-template
                if (strpos($typeReq, 'message_templates?access_token=') !== false) {
                    $pos = strpos($typeReq, "=");
                    $value = substr($typeReq, $pos + 1);
                    $template = $this->getTableLocator()->get('Templates'); //loadDB
                    $zaps = $this->getTableLocator()->get('Whatsapps');//LoadDB

                    $jsons = $template->find()->where(['api_whatsapp_contanegocio_id' => $id])->first();
                    if ($jsons === null) {
                        $templateFB = $this->redirectFacebook->getTemplate(Router::url(null, false));
                        header('Content-Type: application/json');
                        die(json_encode($templateFB));
                    }
                    $whatsapps = $zaps->find('all')->where(['id_contanegocios_api' => $id])->first();
                    $expected_value = $whatsapps->numero_telefone;

                    if (preg_match('/^[a-zA-Z0-9\/\+]*={0,2}$/', $value) && base64_decode($value, true) === $expected_value) {
                        header('Content-Type: application/json');
                        die($jsons->json);
                    } else {
                        $templateFB = $this->redirectFacebook->getTemplate(Router::url(null, false));
                       // header('Content-Type: application/json');
                        die(json_encode($templateFB));
                    }
                }
            }


            $parametros = $this->request->getServerParams();
            $bearerToken = $parametros['HTTP_AUTHORIZATION'];
            $bearerToken = str_replace("Bearer ", '', $bearerToken);
            (string)$verificar = base64_decode($bearerToken, true);


            if (is_numeric($id) && ctype_digit($id)) {

                $jsonTofacebook = $this->redirectFacebook->mediamessage(Router::url(null,false),$bearerToken);
                header('Content-Type: application/json');
                die($jsonTofacebook);

            }


            /*  if(substr($verificar, 0, 1) !== "+") {*/
            /*if (strpos($verificar, '+') !== 0) {
                //block redrect to facebook
                $jsonTofacebook = $this->request->getParsedBody();
                $jsonTofacebook = $this->redirectFacebook->mediamessage(Router::url(null,false),$bearerToken);
                header('Content-Type: application/json');
                die($jsonTofacebook);
                //End block redrect to facebook

            }*/

            $zapis = $this->getTableLocator()->get('Whatsapps');
            if (preg_match('/^[a-zA-Z0-9\/\+]*={0,2}$/', $bearerToken)){
                    $number = base64_decode($bearerToken);
                    $zapi = $zapis->find('all')->where(['numero_telefone' => $number])->first();
                    if ($zapi != null){
                        $mediaURL = $this->mediaDownload->getURL($id, $zapi->instancia, $zapi->api_key_server);
                        header('Content-Type: application/json');
                        die($mediaURL);
                    }else{
                        echo 'aqui';
                        exit;
                    }
            }else{

                //block redrect to facebook
                $jsonTofacebook = $this->redirectFacebook->mediamessage(Router::url(null,false),$bearerToken);
                header('Content-Type: application/json');
                die($jsonTofacebook);
                //End block redrect to facebook
                //enviar pro facebook;
            }

            //End of firstBlock Contain message_template
            //Start Second block contain ID of message;

          /*  else {
                throw new UnauthorizedException('Acesso não autorizado');
            }*/

        }


        if ($this->request->is('post')) {
            $bearerToken = $this->request->getHeader('Authorization');
            if (!$bearerToken) {
                throw new UnauthorizedException('Acesso não autorizado');
            }

            $token = str_replace('Bearer ', '', $bearerToken[0]);

            $template = $this->getTableLocator()->get('Templates'); //loadDB
            $zaps = $this->getTableLocator()->get('Whatsapps');//LoadDB
            $jsons = $template->find()->where(['api_whatsapp_id_telefone' => $id])->first();
            if ($jsons === null){
                //block redrect to facebook
                $jsonTofacebook = $this->request->getParsedBody();
                $jsonTofacebook = $this->redirectFacebook->message(json_encode($jsonTofacebook),Router::url(null,false),'post',$token);
                header('Content-Type: application/json');
                die($jsonTofacebook);
                //End block redrect to facebook

            }
            $whatsapps = $zaps->find('all')->where(['id_telefone' => $id])->first();

            if($whatsapps == null){

                //block redrect to facebook
                $jsonTofacebook = $this->request->getParsedBody();
                $jsonTofacebook = $this->redirectFacebook->message(json_encode($jsonTofacebook),Router::url(null,false),'post',$token);
                header('Content-Type: application/json');
                die($jsonTofacebook);
                //End block redrect to facebook

            }
            $expected_value = $whatsapps->numero_telefone;
            if (preg_match('/^[a-zA-Z0-9\/\+]*={0,2}$/', $token) && base64_decode($token, true) === $expected_value) {
                $data = $this->request->getParsedBody();

                switch ($data['type']){
                    case 'template':

/*                        if ($data['to'] === str_replace('+','',$whatsapps->numero_telefone)){

                            $checarInstancia = $this->codechatServer->connectInstance();
                            if (array_key_exists('base64', $checarInstancia)){


                            }else{
                                $retorno = $this->codechat->enviarText($whatsapps->api_key_server, $data['to'], "Instancia já conectada!", $whatsapps->instancia);
                            }
                         //   $retorno = $this->codechat->enviarText($whatsapps->api_key_server, $data['to'], $msg, $whatsapps->instancia);



                        }*/


                        $msg = json_decode($jsons->json);
                        $msg = $msg->data[0]->components[0]->text;
                        $retorno = $this->codechat->enviarText($whatsapps->api_key_server, $data['to'], $msg, $whatsapps->instancia);
                        header('Content-Type: application/json');
                        die($retorno);


                    case 'text':

                        $text = $this->codechat->enviarText($whatsapps->api_key_server, $data['to'], $data['text']['body'], $whatsapps->instancia);
                        header('Content-Type: application/json');
                        die($text);

                    case 'audio':

                        $audio = $this->codechat->sendAudio($whatsapps->api_key_server, $data['to'], $data['audio']['link'], $whatsapps->instancia);
                        header('Content-Type: application/json');
                        die($audio);

                    case 'image':

                        if (array_key_exists('caption',$data['image'])){
                            $caption = $data['image']['caption'];
                        }else{
                            $caption = null;
                        }
                        $image = $this->codechat->sendImage($whatsapps->api_key_server, $data['to'], $data['image']['link'], $whatsapps->instancia, $caption);
                        header('Content-Type: application/json');
                        die($image);

                    case 'video':

                        if (array_key_exists('caption',$data['video'])){
                            $caption = $data['video']['caption'];
                        }else{
                            $caption = null;
                        }
                        $video = $this->codechat->sendVideo($whatsapps->api_key_server, $data['to'], $data['video']['link'], $whatsapps->instancia, $caption);
                        header('Content-Type: application/json');
                        die($video);

                    case 'document':

                        if (array_key_exists('caption',$data['document'])){
                            $caption = $data['document']['caption'];
                        }else{
                            $caption = null;
                        }

                        $document = $this->codechat->sendDocument($whatsapps->api_key_server, $data['to'], $data['document']['link'], $whatsapps->instancia, $data['document']['filename'], $caption);
                        header('Content-Type: application/json');
                        die($document);

                }

            } else {

                //block redrect to facebook
                $jsonTofacebook = $this->request->getParsedBody();
                $jsonTofacebook = $this->redirectFacebook->message(json_encode($jsonTofacebook),Router::url(null,false),'post',$token);
                header('Content-Type: application/json');
                die($jsonTofacebook);
                //End block redrect to facebook


            }
        }









    }

}
