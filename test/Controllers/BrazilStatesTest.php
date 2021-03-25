<?php


namespace Tests\Controllers;


class BrazilStatesTest extends \PHPUnit\Framework\TestCase
{
    private $model;

    //
    public function testGetStatesApiNotResponse()
    {
        $this->model = \App\Controllers\BrazilStates::getStates();

        $this->assertTrue($this->model);
    }

    // requisicao index
    public function testIndex()
    {
        $this->model = \App\Controllers\BrazilStates::index();

        $this->assertTrue($this->model);
    }
}