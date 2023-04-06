<?php
declare(strict_types=1);

namespace App\Controller;


class InstallController extends AppController
{
    public function index()
    {
    if (env('INSTALLED') == 1){
        die();
    }






      //  $this->set(compact('install'));
    }

}
