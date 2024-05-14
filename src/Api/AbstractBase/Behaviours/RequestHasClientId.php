<?php

namespace Paytic\Smartfintech\Api\AbstractBase\Behaviours;

trait RequestHasClientId
{

    public string $client_id;

    public function getClientId(): string
    {
        return $this->client_id;
    }

    public function setClientId(string $client_id): void
    {
        $this->client_id = $client_id;
    }


    protected static function validateParamClientId(array $params = []): void
    {
        if (!isset($params['client_id'])) {
            throw new \Exception('client_id parameter must be a string');
        }
    }

}

