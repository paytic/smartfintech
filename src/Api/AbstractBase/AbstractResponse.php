<?php

namespace Paytic\Smartfintech\Api\AbstractBase;

use Psr\Http\Message\ResponseInterface;

class AbstractResponse
{
    protected ResponseInterface $httpResponse;

    public string $statusCode;
    public string $status;

    public function __construct(ResponseInterface $httpResponse)
    {
        $this->httpResponse = $httpResponse;
        $this->populateFromHttpResponse($httpResponse);
    }

    public static function create(ResponseInterface $httpResponse): static
    {
        return new static($httpResponse);
    }

    protected function populateFromHttpResponse(ResponseInterface $httpResponse)
    {
        $this->statusCode = $httpResponse->getStatusCode();
        $this->status = $httpResponse->getReasonPhrase();

        $body = $httpResponse->getBody()->getContents();
        var_dump($body);
        die();
    }
}
