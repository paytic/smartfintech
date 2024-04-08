<?php

namespace Paytic\Smartfintech\Client;

use Paytic\Smartfintech\Api\AbstractBase\BaseResponse;
use Paytic\Smartfintech\Api\Authentication\AuthenticationRequest;

trait HasApiEndpoints
{

    public function authenticate(array|AuthenticationRequest $params): BaseResponse
    {
        $request = AuthenticationRequest::create($params);
        return $this->sendApiRequest($request);
    }

}