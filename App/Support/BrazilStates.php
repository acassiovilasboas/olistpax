<?php


namespace App\Support;


class BrazilStates
{
    private $apiUrl;
    private $callback;

    public function __construct()
    {
        $this->apiUrl = 'https://servicodados.ibge.gov.br/api/v1/localidades/estados';
    }

    public function getBrazilStates()
    {
        $this->get();
    }

    public function callback()
    {
        return $this->callback;
    }


    private function get()
    {
        $ch = curl_init($this->apiUrl);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'GET');
        $this->callback = json_decode(curl_exec($ch));

        curl_close($ch);
    }
}