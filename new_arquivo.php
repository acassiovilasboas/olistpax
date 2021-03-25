<?php

use App\Models\Category;
use App\Models\Product;

require 'vendor/autoload.php';


$model = (new Product())->find()->order('id')->fetch(true);
$lastId = $model[sizeof($model)-1]->id;

$objectOld = (new Product())->findById($lastId);

$object = \App\Controllers\Product::edit([
    'id' => $lastId,
    'name' => "newProductTestOverwritten",
    'category_id' => 2,
    'price' => 5.9
]);

$objectUpdated = (new Product())->findById($lastId);



print_r($objectOld->quantity . PHP_EOL);
print_r($objectUpdated->quantity . PHP_EOL);