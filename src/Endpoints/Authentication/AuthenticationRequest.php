<?php

namespace Paytic\Smartfintech\Endpoints\Authentication;

class AuthenticationRequest
{
    public string $client_id;

    public bool $isLink2Pay = true;

    public bool $flexibleURL = true;

    public bool $isHeadless = true;

    /**
     * @param string $client_id
     */
    public function __construct(string $client_id)
    {
        $this->client_id = $client_id;
    }

    public static function create(array|string $params = []): static
    {
        if (is_string($params)) {
            $client_id = $params;
            $params = [];
        } else {
            $client_id = $params['client_id'] ?? null;
            if (empty($client_id)) {
                throw new \Exception("Missing client_id");
            }
            unset($params['client_id']);
        }
        $request = new static($client_id);
        foreach ($params as $name => $value) {
            $request->$name = $value;
        }
        return $request;
    }
}

