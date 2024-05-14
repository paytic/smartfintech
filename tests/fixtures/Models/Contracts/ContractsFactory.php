<?php

namespace Paytic\Smartfintech\Tests\Fixtures\Models\Contracts;

use Paytic\Smartfintech\Models\Contract;

class ContractsFactory
{
    public static function createFull(): Contract
    {
        return Contract::create(static::createFullData());
    }

    public static function createFullData(): array
    {
        return [
            'name' => 'Yolo Events',
            'cifCnp' => 'RO123456779',
            'tradeRegisterNumber' => 'J40/1234/2021',
            'officeAddress' => 'Bd. Eroilor 1',
            'county' => 'Bucuresti',
            "bank" => "BT",
            "iban" => "RO45BTRLRONINCS000739101",
            'contactPerson' => 'John Doe',
            'contactEmail' => 'gabriel@yoloevents.ro',
            'contactPhone' => '0741000000',
            'vatPayer' => true,
            'vatRate' => 19,
            'nonpayingVAT' => false,
            'persAcceptTCSF' => 'nume_user',
            'correspondanceAddress' => 'str. undeva pe aici',
            'role' => 'Presedinte',
            'platformURL' => 'https://www.42km.ro/',
            'logo' => 'data:image/png;base64,ljkjlml',
        ];
    }
}

