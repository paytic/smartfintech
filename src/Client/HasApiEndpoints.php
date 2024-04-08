<?php

namespace Paytic\Smartfintech\Client;

use Paytic\Smartfintech\Api\AbstractBase\AbstractResponse;
use Paytic\Smartfintech\Api\Authentication\AuthenticationRequest;
use Paytic\Smartfintech\Api\SinglePaymentInitiation\SinglePaymentInitiationRequest;
use Paytic\Smartfintech\Api\SinglePaymentInitiation\SinglePaymentInitiationResponse;

trait HasApiEndpoints
{

    public function authenticate(array|AuthenticationRequest $params): AbstractResponse
    {
        $request = AuthenticationRequest::create($params);
        return $this->sendApiRequest($request);
    }

    public function initSinglePayment(array|SinglePaymentInitiationRequest $params): AbstractResponse|SinglePaymentInitiationResponse
    {
        $request = SinglePaymentInitiationRequest::create($params);
        return $this->sendApiRequest($request);
    }
}