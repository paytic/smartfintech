<?php

namespace Paytic\Smartfintech\Api\Authentication;

use Paytic\Smartfintech\Api\AbstractBase\BaseResponse;
use Paytic\Smartfintech\Api\Authentication\Dto\AuthResponse;

class AuthenticationResponse extends BaseResponse
{
    public AuthResponse|null $result = null;
}