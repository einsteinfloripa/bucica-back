<?php
require_once __DIR__ . '/vendor/autoload.php';
$dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
$dotenv->load();

header('Content-type: application/json; charset=utf-8');
$URL = explode("/",$_SERVER[ 'REQUEST_URI' ]);
$INPUT =  json_decode(file_get_contents('php://input'), TRUE);

$ret = require_once "./src/routes.php";

http_response_code($ret[0]);

if ($ret[0] >= 400) {
    echo json_encode(array("Err" => $ret[1]));
} else {
    echo json_encode(array("Msg" => $ret[1]));
}

    
    