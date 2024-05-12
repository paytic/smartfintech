<?php

namespace Paytic\Smartfintech\Client;

use Paytic\Smartfintech\Api\AbstractBase\AbstractResponse;
use Paytic\Smartfintech\Api\Authentication\AuthenticationRequest;
use Paytic\Smartfintech\Api\Client\ClientActivationRequest;
use Paytic\Smartfintech\Api\PaymentInitiationSingle\PaymentInitiationSingleRequest;
use Paytic\Smartfintech\Api\PaymentInitiationSingle\PaymentInitiationSingleResponse;
use Paytic\Smartfintech\Api\PaymentStatus\PaymentStatusRequest;

trait HasApiEndpoints
{

    public function authenticate(array|AuthenticationRequest $params): AbstractResponse
    {
        $request = AuthenticationRequest::create($params);
        return $this->sendApiRequest($request);
    }

    public function clientActivation(array|ClientActivationRequest $params): AbstractResponse|PaymentInitiationSingleResponse
    {
        $request = ClientActivationRequest::create($params);
        return $this->sendApiRequest($request);
    }

    public function paymentInitiationSingle(array|PaymentInitiationSingleRequest $params): AbstractResponse|PaymentInitiationSingleResponse
    {
        $request = PaymentInitiationSingleRequest::create($params);
        return $this->sendApiRequest($request);
    }

    public function paymentStatus(array|PaymentStatusRequest $params): AbstractResponse
    {
        $request = PaymentStatusRequest::create($params);
        return $this->sendApiRequest($request);
    }
}