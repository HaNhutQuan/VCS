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

require base_path('vendor/autoload.php');
use Cloudinary\Cloudinary;
use Cloudinary\Api\Upload\UploadApi;
use Cloudinary\Configuration\Configuration;

function uploadFile($file) {

    $config = require base_path("config/config.php");
    var_dump($config);
    Configuration::instance([
        'cloud' => [
            'cloud_name' => $config['cloudinary']['cloud_name'],
            'api_key'    => $config['cloudinary']['api_key'],
            'api_secret' => $config['cloudinary']['api_secret'],
        ]
    ]);

    try {
        $upload = (new UploadApi())->upload($file, [
            "folder" => "uploads", 
            "resource_type" => "auto",
            "use_filename" => true,
            "unique_filename" => false,
            "overwrite" => true
        ]);

        return $upload['secure_url'] ?? "Upload failed: No URL returned";
    } catch (Exception $e) {
        return "Upload failed: " . $e->getMessage();
    }
}