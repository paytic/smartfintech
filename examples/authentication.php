<?php

use Paytic\Smartfintech\Api\Authentication\AuthenticationRequest;
use Paytic\Smartfintech\SmartfintechClient;

require __DIR__ . '/_init.php';

$request = AuthenticationRequest::create([
    'certificate' => $_ENV['SMARTFINTECH_CERTIFICATE'] ?? '',
    'private_key' => $_ENV['SMARTFINTECH_PRIVATE_KEY'] ?? '',
    'client_id' => $_ENV['SMARTFINTECH_CLIENT_ID'] ?? '',
]);

$client = new SmartfintechClient();
$response = $client->authenticate($request);

var_dump($response);