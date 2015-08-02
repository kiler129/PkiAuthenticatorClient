<?php
require_once('../config.php');
session_start();

if (!isset($_GET['auth'])) {
    throw new InvalidArgumentException('No auth data found');
}

$key = openssl_pkey_get_public('file://' . SERVER_PUB_KEY);
if ($key === false) {
    throw new RuntimeException('Failed to read server public key');
}

$data = base64_decode($_GET['auth']);
if (empty($data)) {
    throw new RuntimeException('Failed to decode auth data');
}

if (!openssl_public_decrypt($data, $dctData, $key)) {
    throw new RuntimeException('Failed to decrypt auth data');
}

$dctData = json_decode($dctData, true);
if (empty($dctData)) {
    throw new RuntimeException('Failed to decode payload');
}

if (!isset($dctData['nonce'], $_SESSION['_pkiAuth']['nonce']) || $_SESSION['_pkiAuth']['nonce'] !== $dctData['nonce']) {
    throw new LogicException('Nonce missmatch - invalid auth');
}

if (!isset($dctData['_code'])) {
    throw new LogicException('Invalid data - code not found');
}

if ($dctData['_code'] != 1) {
    throw new RuntimeException('Login failed with code ' . $dctData['_code']);
}

if (!isset($dctData['_time'], $_SESSION['_pkiAuth']['time'])) {
    throw new RuntimeException('No time in response or session');
}

if ((time() - $_SESSION['_pkiAuth']['time']) > RESPONSE_TIMEOUT) {
    throw new RuntimeException('Response was generated ' . (time() - $_SESSION['_pkiAuth']['time']) . 's ago - it is too long (check clock synchronization between servers!)');
}

if (($dctData['_time'] - $_SESSION['_pkiAuth']['time']) > REQUEST_TIMEOUT) {
    throw new RuntimeException('Request was generated ' . ($dctData['_time'] - $_SESSION['_pkiAuth']['time']) . 's after request - it is too long');
}

echo "Authentication success, login: " . $dctData['uname'];
