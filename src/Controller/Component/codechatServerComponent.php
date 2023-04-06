<?php

namespace App\Controller\Component;
use Cake\Controller\Component;
use Cake\Http\Client;
use Cake\Http\Client\Request as ClientRequest;

class codechatServerComponent extends Component{


    function url(){
        return env('FULL_HOST_WHATS');
    }

    function api(){
        return env('API_KEY_WHATS');
    }


    public function logout($instance){

        $http = new Client([
            'headers' => ['apikey' => $this->api()]
        ]);
        $response = $http->delete(
            $this->url().'/instance/logout/'.$instance);
        return $response->getJson();

    }

    public function delete($instance){

        $http = new Client([
            'headers' => ['apikey' => $this->api()]
        ]);
        $response = $http->delete(
            $this->url().'/instance/delete/'.$instance);
        return $response->getJson();

    }
    public function checkInstance($instancia){
        $http = new Client([
            'headers' => ['apikey' => $this->api()]
        ]);
        $response = $http->get(
            $this->url().'/instance/fetchInstances?instanceName='.$instancia);

        if ($response->isOk()){
            return $response->getJson();
        }else{
            return $response->getJson();
        }

    }


    public function connection($instancia){
        $http = new Client([
            'headers' => ['apikey' => $this->api()]
        ]);
        $response = $http->get(
            $this->url().'/instance/connect/'.$instancia);


        if ($response->isOk()){
            return $response->getJson();
        }else{
            return $response->getJson();
        }


    }
    public function newZAP($instancia){

        $http = new Client([
            'headers' => ['apikey' => $this->api()]
        ]);
        $data = array('instanceName' => $instancia);

        $response = $http->post(
            $this->url().'/instance/create',
            json_encode($data),
            ['type' => 'json']
        );

        if ($response->isOk()){
            return $response->getJson();
        }else{
            return 'Error';
        }

    }




}
