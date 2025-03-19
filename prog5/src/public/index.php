<?php
require_once __DIR__ . "/../app/init.php";

$routes = require_once __DIR__ . "/../routes/route.php";


$request = parse_url($_SERVER["REQUEST_URI"], PHP_URL_PATH);
$method = $_SERVER["REQUEST_METHOD"];


if(isset($routes[$method][$request])) {
    list($controller, $action) = explode("@", $routes[$method][$request]);

    $controllerInstance = new $controller();
    echo ($controllerInstance->$action());
}else {
    http_response_code(404);
    die("<h1>404 - NOT FOUND</h1>");
}
