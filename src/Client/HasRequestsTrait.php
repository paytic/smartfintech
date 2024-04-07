<?php

namespace Paytic\Smartfintech\Client;

use Paytic\Smartfintech\Api\AbstractBase\BaseRequest;
use Paytic\Smartfintech\Api\AbstractBase\BaseResponse;
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
    public function sendApiRequest(BaseRequest $request): BaseResponse
    {
        return $this->getRequestManager()->sendApiRequest($request);
    }

}