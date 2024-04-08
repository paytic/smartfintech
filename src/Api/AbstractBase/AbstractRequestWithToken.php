<?php

namespace Paytic\Smartfintech\Api\AbstractBase;

abstract class AbstractRequestWithToken extends AbstractRequest
{
    protected ?string $accessToken = null;

    protected static function createValidateParams(array $params = []): void
    {
        parent::createValidateParams($params);
        if (!isset($params['accessToken'])) {
            throw new \Exception('accessToken not set');
        }
    }

    public function setAccessToken(string $accessToken): void
    {
        $this->accessToken = $accessToken;
    }

    public function getHeaders(): array
    {
        $headers = parent::getHeaders();
        $headers['Authorization'] = 'Bearer ' . $this->accessToken;
        return $headers;
    }
}
