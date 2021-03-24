<?php

// DATALAYER

define("DATA_LAYER_CONFIG", [
    "driver" => "mysql",
    "host" => "127.0.0.1",
    "port" => "3306",
    "dbname" => "olist",
    "username" => "acassio",
    "passwd" => "toor",
    "options" => [
        PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8",
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_OBJ,
        PDO::ATTR_CASE => PDO::CASE_NATURAL
    ]
]);


// URL PADRAO
define("URL_BASE", "http://localhost/olist");