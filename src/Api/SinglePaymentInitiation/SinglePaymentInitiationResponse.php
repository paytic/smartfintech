<?php

namespace Paytic\Smartfintech\Api\SinglePaymentInitiation;

use Paytic\Smartfintech\Api\AbstractBase\BaseResponse;
use Paytic\Smartfintech\Api\Authentication\Dto\AuthResponse;

class SinglePaymentInitiationResponse extends BaseResponse
{
    public ?string $redirectUri = null;
}