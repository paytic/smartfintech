<?php

namespace Paytic\Smartfintech\Client;

use Paytic\Smartfintech\Api\AbstractBase\AbstractRequest;
use Paytic\Smartfintech\Api\AbstractBase\AbstractResponse;
use Paytic\Smartfintech\HttpClient\RequestManager;

trait HasRequestsTrait
{
    protected ?RequestManager $requestManager = null;

    public function getRequestManager(): RequestManager
    {
        if ($this->requestManager === null) {
            $this->requestManager = new RequestManager($this->getHttpClientBuilder());
        }

        return $this->requestManager;
    }
    public function sendApiRequest(AbstractRequest $request): AbstractResponse
    {
        return $this->getRequestManager()->sendApiRequest($request);
    }

}