<?php


namespace App\Controllers;


class Error
{
    public function error($data)
    {
        echo "<h1>Erro {$data['errcode']}</h1>";
    }
}