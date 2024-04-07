<?php

namespace Paytic\Smartfintech\HttpClient;

trait HasClientBuilder
{
    protected ?ClientBuilder $httpClientBuilder = null;

    public function setHttpClientBuilder(ClientBuilder $httpClientBuilder)
    {
        $this->httpClientBuilder = $httpClientBuilder;
        return $this;
    }

    public function getHttpClientBuilder(): ClientBuilder
    {
        return $this->httpClientBuilder;
    }
}