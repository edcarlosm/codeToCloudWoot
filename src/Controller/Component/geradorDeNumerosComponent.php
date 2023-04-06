<?php
namespace App\Controller\Component;

use Cake\Controller\Component;

class geradorDeNumerosComponent extends Component
{


    public function gerarIDTel(){

        $randomNumber = mt_rand(10000000000000, 99999999999999);
        $randomNumber = ltrim($randomNumber, '0');
        return $randomNumber;

    }


    public function gerarUniquidNumber(){

        $randomNumber = mt_rand(10000000000000, 99999999999999);
        $randomNumber = ltrim($randomNumber, '0');
        return $randomNumber;


    }

}
