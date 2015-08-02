<?php
require_once('../config.php');

session_start();
$key = openssl_pkey_get_private('file://' . SERVICE_PRV_KEY);
if ($key === false) {
    throw new RuntimeException('Failed to read service private key');
}

$nonce = unpack('H*', openssl_random_pseudo_bytes(32))[1];
$data = ['nonce' => $nonce, 'uname' => 'happyUser'];

$data = json_encode($data); //Pack array to string
if (!openssl_private_encrypt($data, $encData, $key)) {
    throw new RuntimeException('Payload encryption failed');
}
$encData = base64_encode($encData); //Encrypt & pack into b64

$_SESSION['_pkiAuth'] = ['nonce' => $nonce, 'time' => time()];

$url = sprintf(SERVER_ADDR, urlencode($encData));

echo "<b>URL to go:</b> <a href=\"$url\">$url</a>";
