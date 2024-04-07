<?php

namespace Paytic\Smartfintech\Client;

use Paytic\Smartfintech\Api\Authentication\AuthenticationRequest;
use Paytic\Smartfintech\Api\Authentication\AuthResponse;

trait HasApiEndpoints
{

    public function authenticate(array|AuthenticationRequest $params): AuthResponse
    {
        $request = AuthenticationRequest::create($params);
        return $this->sendApiRequest($request);
    }

}