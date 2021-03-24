<?php

require_once 'vendor/autoload.php';

use CoffeeCode\Router\Router;

$router = new Router(URL_BASE);

$router->group(null);

$router->get("/", function() {
    echo "Para usar a api, acesse <a href='" . URL_BASE . "/api'>localhost/api</a>";
});


$router->group("ooops");
$router->get("/{errcode}", function($data) {
    echo "<h1>Erro {$data['errcode']}</h1>";
});

$router->dispatch();

if($router->error()) {
    $router->redirect("/ooops/{$router->error()}");
}