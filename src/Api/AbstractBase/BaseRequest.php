<?php

namespace Paytic\Smartfintech\Api\AbstractBase;

abstract class BaseRequest
{
    protected ?string $path = null;

    protected ?string $method = null;

    protected ?string $responseClass = null;

    public function getUri(): ?string
    {
        return $this->getPath();
    }

    public function getPath(): ?string
    {
        if ($this->path === null) {
            $this->path = $this->generatePath();
        }
        return $this->path;
    }

    public function getMethod(): ?string
    {
        if ($this->method === null) {
            $this->method = $this->generateMethod();
        }
        return $this->method;
    }

    public function getBody()
    {

        return null;
    }

    public function getHeaders(): array
    {
        return [];
    }

    protected function generatePath()
    {
        if (defined('static::PATH')) {
            return static::PATH;
        }
        throw new \Exception('Path not defined');
    }

    protected function generateMethod()
    {
        if (defined('static::METHOD')) {
            return static::METHOD;
        }
        return 'GET';
    }

    public function getResponseClass()
    {
        if ($this->responseClass === null) {
            $this->responseClass = $this->generateResponseClass();
        }
        return $this->responseClass;
    }

    protected function generateResponseClass(): string
    {
        return BaseResponse::class;
    }
}
