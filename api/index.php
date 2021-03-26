<?php

require_once '../vendor/autoload.php';

use App\Models;
use CoffeeCode\Router\Router;

$router = new Router(URL_BASE . '/api');


/*
 * Controllers
 */
$router->namespace("App\Controllers");

//$router->group(null);
$router->get('/', function(){echo "<a href='https://documenter.getpostman.com/view/9912123/TzCHCWFa' target='_blank'>Consulte a documentação</a>";});


/*
 * CATEGORY
 */
$router->group("category");
$router->get('/', "Category:index");
$router->get('/{id}', "Category:findById");
$router->post('/', "Category:create");
$router->post('/{id}', "Category:edit");
$router->delete('/{id}', "Category:delete");


/*
 * PRODUCT
 */
$router->group("product");
$router->get('/', "Product:index");
$router->get('/{id}', "Product:findById");
$router->post('/', "Product:create");
$router->post('/{id}', "Product:edit");
$router->delete('/{id}', "Product:delete");


/*
 * STATES
 */
$router->group("states");
$router->get('/', "BrazilStates:index");
$router->post('/', "BrazilStates:create");
$router->delete('/', "BrazilStates:delete");


/*
 * ERRORS
 */
$router->group("ooops");
$router->get("/{errcode}", function($data) {
    echo "<h1>Erro {$data['errcode']}</h1>";
});


$router->dispatch();

if($router->error()) {
    $router->redirect("/ooops/{$router->error()}");
}

