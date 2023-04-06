<?php

namespace App\Controller\Component;

use Cake\Controller\Component;

class messageTemplatesComponent extends Component
{

    function BasicTemplate()
    {
        return '{"data":[{"id":1,"name":"hello","status":"APPROVED","category":"UTILITY","language":"pt_BR","components":[{"text":"Olá Tudo Bem?!","type":"BODY"}]}]}';
    }


}
