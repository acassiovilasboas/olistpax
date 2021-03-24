<?php


namespace App\Models;

use CoffeeCode\DataLayer\DataLayer;


class BrazilStates extends DataLayer
{
    public function __construct()
    {
        parent::__construct("brazil_states", []);
    }
}