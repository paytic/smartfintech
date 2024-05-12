<?php

use Paytic\Smartfintech\Api\Authentication\AuthenticationRequest;
use Paytic\Smartfintech\Api\Client\ClientActivationRequest;
use Paytic\Smartfintech\Models\Contract;
use Paytic\Smartfintech\SmartfintechClient;
use Paytic\Smartfintech\Tests\Fixtures\Models\Contracts\ContractsFactory;

require __DIR__ . '/_init.php';

$client = new SmartfintechClient();
$client->isSandbox(true);

$request = AuthenticationRequest::create([
    'certificate' => $_ENV['SMARTFINTECH_CERTIFICATE'] ?? '',
    'private_key' => $_ENV['SMARTFINTECH_PRIVATE_KEY'] ?? '',
    'client_id' => $_ENV['SMARTFINTECH_CLIENT_ID'] ?? '',
]);
$response = $client->authenticate($request);

$contractData = $_POST['contract'] ?? ContractsFactory::createFullData();
$contract = Contract::create($contractData);
$request = ClientActivationRequest::create([
    'platform' => '42km',
    'contract' => $contract,
]);

$response = $client->clientActivation($request);
var_dump($response);
