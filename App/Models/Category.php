<?php


namespace App\Models;


use CoffeeCode\DataLayer\DataLayer;

class Category extends DataLayer
{
    public function __construct()
    {
        parent::__construct("category", ["name"]);
    }

    public function category()
    {
        return (new Product())->find("category_id = :id", "id={$this->id}")->fetch(true);
    }
}