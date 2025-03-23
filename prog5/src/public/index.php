<?php
require_once __DIR__ . "/../app/init.php";

$routes = require_once __DIR__ . "/../routes/route.php";


$requestUri = parse_url($_SERVER["REQUEST_URI"], PHP_URL_PATH);
$method = $_SERVER["REQUEST_METHOD"];

$route = $routes[$method][$requestUri] ?? $routes["GET"]["/404"];
[$controller, $action] = explode("@", $route);


$controllerInstance = new $controller();


if (!method_exists($controllerInstance, $action)) {
    die("Method '$action' not found in controller '$controller'.");
}

echo $controllerInstance->$action();
