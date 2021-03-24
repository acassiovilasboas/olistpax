<?php


namespace App\Models;

use CoffeeCode\DataLayer\DataLayer;


class Product extends DataLayer
{
    public function __construct()
    {
        parent::__construct("product", ["category_id", "name", "price"]);
    }

    public function category()
    {
        return (new Category())->find("id = :category_id", "category_id={$this->category_id}")->fetch();
    }
}