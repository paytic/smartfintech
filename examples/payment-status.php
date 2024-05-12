<?php

use Paytic\Smartfintech\Api\Authentication\AuthenticationRequest;
use Paytic\Smartfintech\Api\PaymentInitiationSingle\PaymentInitiationSingleRequest;
use Paytic\Smartfintech\Api\PaymentInitiationSingle\PaymentInitiationSingleResponse;
use Paytic\Smartfintech\Api\PaymentStatus\PaymentStatusRequest;
use Paytic\Smartfintech\SmartfintechClient;

require __DIR__ . '/_init.php';

$client = new SmartfintechClient();

$request = AuthenticationRequest::create([
    'certificate' => $_ENV['SMARTFINTECH_CERTIFICATE'] ?? '',
    'private_key' => $_ENV['SMARTFINTECH_PRIVATE_KEY'] ?? '',
    'client_id' => $_ENV['SMARTFINTECH_CLIENT_ID'] ?? '',
]);
$response = $client->authenticate($request);

$accessToken = $response->result->access_token;
$paymentId = $response->result->paymentId;

$pisRequest = PaymentStatusRequest::create([
    'accessToken' => $accessToken,
    'paymentId' => $paymentId,
]);
$response = $client->paymentStatus($pisRequest);
var_dump($response);

if ($response instanceof PaymentInitiationSingleResponse) {
    echo 'Payment initiated successfully! <br />';
    echo '<a href="' . $response->redirectUri . '">Click here to complete the payment</a>';
} else {
    echo 'Payment initiation failed';
}