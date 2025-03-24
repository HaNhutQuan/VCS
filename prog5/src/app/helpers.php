<?php
require_once  base_path('vendor/autoload.php');

use Cloudinary\Cloudinary;
use Cloudinary\Api\Upload\UploadApi;
use Cloudinary\Configuration\Configuration;

function base_url($path = "")
{
    $protocol = "http://";
    $host = $_SERVER["HTTP_HOST"];
    $base = rtrim($_SERVER["SCRIPT_NAME"], "/");

    return $protocol . $host . "/" . ltrim($path, "/");
}
function base_path($path = "")
{
    return realpath(__DIR__ . "/../" . "/" . ltrim($path, '/'));
}

function view_path($path = "")
{

    return base_path("app/views/" . ltrim($path, '/'));
}

function render($view = "", $data = [])
{
    extract($data);

    ob_start();

    require view_path($view);

    return ob_get_clean();
}

function validateUploadFile($file, $extraTypes = [])
{
    $maxSize = 5 * 1024 * 1024; // 5MB

    if ($file['size'] > $maxSize) {
        return 'Tệp quá lớn (tối đa 5MB).';
    }
    // 'pdf'  => 'application/pdf',
    //     'doc'  => 'application/msword',
    //     'docx' => 'application/vnd.openxmlformats-officedocument.wordprocessingml.document'
    $allowedTypes = array_merge([
        'jpg'  => 'image/jpeg',
        'jpeg' => 'image/jpeg',
        'png'  => 'image/png',
        'svg'  => 'image/svg+xml'
    ], $extraTypes);

    $mimeType = mime_content_type($file['tmp_name']) ?? '';
    $fileExtension = strtolower(pathinfo($file['name'], PATHINFO_EXTENSION));


    if (!isset($allowedTypes[$fileExtension]) || $allowedTypes[$fileExtension] !== $mimeType) {
        return 'Tệp không hợp lệ hoặc không được hỗ trợ.';
    }

    return true;
}



function uploadFile($file)
{

    $config = require base_path("config/config.php");

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

// ChatGPT hân hạnh tài trợ chương trình này :))
function remove_vietnamese_accent($str) {
    $str = preg_replace('/[àáạảãâầấậẩẫăằắặẳẵ]/u', 'a', $str);
    $str = preg_replace('/[èéẹẻẽêềếệểễ]/u', 'e', $str);
    $str = preg_replace('/[ìíịỉĩ]/u', 'i', $str);
    $str = preg_replace('/[òóọỏõôồốộổỗơờớợởỡ]/u', 'o', $str);
    $str = preg_replace('/[ùúụủũưừứựửữ]/u', 'u', $str);
    $str = preg_replace('/[ỳýỵỷỹ]/u', 'y', $str);
    $str = preg_replace('/đ/u', 'd', $str);
    $str = preg_replace('/[ÀÁẠẢÃÂẦẤẬẨẪĂẰẮẶẲẴ]/u', 'A', $str);
    $str = preg_replace('/[ÈÉẸẺẼÊỀẾỆỂỄ]/u', 'E', $str);
    $str = preg_replace('/[ÌÍỊỈĨ]/u', 'I', $str);
    $str = preg_replace('/[ÒÓỌỎÕÔỒỐỘỔỖƠỜỚỢỞỠ]/u', 'O', $str);
    $str = preg_replace('/[ÙÚỤỦŨƯỪỨỰỬỮ]/u', 'U', $str);
    $str = preg_replace('/[ỲÝỴỶỸ]/u', 'Y', $str);
    $str = preg_replace('/Đ/u', 'D', $str);
    return $str;
}