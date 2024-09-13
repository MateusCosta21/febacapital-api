<?php

namespace app\services;

use yii\base\Component;
use yii\httpclient\Client;

class CepService extends Component
{
    private $baseUrl = 'https://brasilapi.com.br/api/cep/v2/';

    public function validateCep($cep)
    {
        $client = new Client();
        $response = $client->get($this->baseUrl . $cep)->send();

        if ($response->isOk) {
            $data = $response->getData();
            return isset($data['cep']);
        }

        return false;
    }
}


