<?php

use Paytic\Smartfintech\Api\Authentication\AuthenticationRequest;
use Paytic\Smartfintech\Api\SinglePaymentInitiation\SinglePaymentInitiationRequest;
use Paytic\Smartfintech\Api\SinglePaymentInitiation\SinglePaymentInitiationResponse;
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

$pisRequest = SinglePaymentInitiationRequest::create([
    'accessToken' => $accessToken,
    'paymentId' => $paymentId,
    'creditorName' => 'John Doe',
    'creditorIban' => 'RO09PORL7789778256833565',
    'amount' => 10.23,
    'details' => 'Test payment',
    'redirectURL' => 'https://example.com/redirect',
    'psuIntermediarId' => microtime(),
]);
$response = $client->initSinglePayment($pisRequest);

if ($response instanceof SinglePaymentInitiationResponse) {
    echo 'Payment initiated successfully! <br />';
    echo '<a href="' . $response->redirectUri . '">Click here to complete the payment</a>';
} else {
    echo 'Payment initiation failed';
}