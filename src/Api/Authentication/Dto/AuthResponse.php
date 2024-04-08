<?php

namespace Paytic\Smartfintech\Api\Authentication\Dto;

class AuthResponse
{
    public string $access_token;

    public int $paymentId;

    public string $refresh_token;
}