<?php

use Paytic\Smartfintech\Api\Authentication\AuthenticationRequest;
use Paytic\Smartfintech\Api\Client\ContractDisplayRequest;
use Paytic\Smartfintech\SmartfintechClient;

require __DIR__ . '/_init.php';

$contract = \Paytic\Smartfintech\Models\Contract::create([
   'name' => 'Numele Companiei',
    'officeAddress' => 'somewhere in USA',
    'tradeRegisterNumber' => 'numar reg comm',
    'cifCnp' => 'RO123456789',
    'iban' => 'RO09PORL7789778256833565',
    'contactPerson' => 'John Doe',
    'contactEmail' => 'gabriel@yoloevents.ro',
    'role' => 'Presedinte',
    'platformURL' => 'https://www.google.com/',
    'correspondanceAddress' => 'str. undeva pe aici',
]);
$request = ContractDisplayRequest::create([
    'platform' => '42km',
    'contract' => $contract,
]);

echo $request->displayHtml();