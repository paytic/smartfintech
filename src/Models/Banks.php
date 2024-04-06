<?php

namespace Paytic\Smartfintech\Models;

class Banks
{
    public const LIBRA_BANK = 'LIB';

    public const RAIFFEISEN_BANK = 'RZB';

    public const SUPPORTED_BANKS = [
        self::LIBRA_BANK => 'Libra Bank',
        self::RAIFFEISEN_BANK => 'Raiffeisen Bank',
    ];
}