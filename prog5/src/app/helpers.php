<?php

function base_url($path="") {
    $protocol = "http://";
    $host = $_SERVER["HTTP_HOST"];
    $base = rtrim($_SERVER["SCRIPT_NAME"], "/");
    
    return $protocol . $host . "/" . ltrim($path, "/");
}
function base_path($path="") {
    return realpath(__DIR__ . "/../" . "/" . ltrim($path, '/'));
}

function view_path($path="") {
    
    return base_path("app/views/" . ltrim($path, '/'));
}

function render($view = "", $data = []) {
    extract($data);
    
    ob_start();

    require view_path($view);
    
    return ob_get_clean();
}

function uploadFile() {

}