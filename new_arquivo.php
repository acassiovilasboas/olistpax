<?php

require 'vendor/autoload.php';

$model = (new \App\Models\Category());

$model->name = "novacategoria";
$model->save();

print_r($model->id);