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


    $allowedTypes = array_merge([
        'jpg'  => 'image/jpeg',
        'jpeg' => 'image/jpeg',
        'png'  => 'image/png',
    ], $extraTypes);


    $finfo = finfo_open(FILEINFO_MIME_TYPE);
    $mimeType = finfo_file($finfo, $file['tmp_name']);
    finfo_close($finfo);

    $fileExtension = strtolower(pathinfo($file['name'], PATHINFO_EXTENSION));


    if (!isset($allowedTypes[$fileExtension]) || $allowedTypes[$fileExtension] !== $mimeType) {
        return 'Tệp không hợp lệ hoặc không được hỗ trợ.';
    }

    return true;
}



function uploadFile($file, $extension)
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
            "overwrite" => true,
            "format" => $extension,
        ]);

        return $upload['secure_url'] ?? "Upload failed: No URL returned";
    } catch (Exception $e) {
        return "Upload failed: " . $e->getMessage();
    }
}

// ChatGPT hân hạnh tài trợ chương trình này :))
function remove_vietnamese_accent($str)
{
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

function hasStudentAnswered($student_id, $filename)
{
    if (!file_exists($filename)) {
        return false;
    }

    $student_ids = array_map('trim', file($filename, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES));

    return in_array($student_id, $student_ids);
}

function normalizeText($text)
{
    $text = str_replace(["\r\n", "\r", "\n"], " ", $text);
    $text = preg_replace('/\s+/', ' ', $text);
    return trim($text);
}
