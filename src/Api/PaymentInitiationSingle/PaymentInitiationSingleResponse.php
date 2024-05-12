<?php

namespace Paytic\Smartfintech\Api\PaymentInitiationSingle;

use Paytic\Smartfintech\Api\AbstractBase\BaseResponse;
use Paytic\Smartfintech\Api\Authentication\Dto\AuthResponse;

class PaymentInitiationSingleResponse extends BaseResponse
{
    public ?string $redirectUri = null;
}