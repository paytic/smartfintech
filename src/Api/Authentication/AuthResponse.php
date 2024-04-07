<?php

namespace Paytic\Smartfintech\Api\Authentication;

use Paytic\Smartfintech\Api\AbstractBase\BaseResponse;

class AuthResponse extends BaseResponse
{
    public string $access_token;

    public string $paymentId;

    public string $refresh_token;
}