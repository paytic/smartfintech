<?php

namespace Paytic\Smartfintech\Api\AbstractBase;

use Paytic\Smartfintech\HttpClient\RequestManager;

abstract class AbstractRequest
{
    protected ?string $path = null;

    protected ?string $method = null;

    protected ?string $responseClass = null;

    public static function create(array|self $params = []): static
    {
        if ($params instanceof self) {
            return $params;
        }
        $constructorParams = static::createParseConstructorParams($params);
        static::createValidateParams($params);

        return static::doCreate($params, $constructorParams);
    }

    protected static function createParseConstructorParams(array &$params = []): array
    {
        return [];
    }
    protected static function createValidateParams(array $params = []): void
    {
    }

    protected static function doCreate(array|self $params = [], array $constructorParams = []): static
    {
        $request = new static(...$constructorParams);
        foreach ($params as $name => $value) {
            $request->$name = $value;
        }
        return $request;
    }

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

    protected function sendGet(
        RequestManager $manager,
        string         $uri = null,
        array          $params = [],
        array          $headers = null)
    {
        if ($uri === null) {
            $uri = $this->getUri();
        }

        $headers = $headers ?? $this->getHeaders();
        return $manager->get(
            $uri,
            $params,
            $headers,
        );
    }

    protected function sendPost(
        RequestManager $manager,
        string         $uri = null,
        array|string   $body = [],
        array          $headers = null,
        array          $files = [],
        array          $uriParams = [])
    {
        if ($uri === null) {
            $uri = $this->getUri();
        }

        $headers = $headers ?? $this->getHeaders();
        return $manager->post(
            $uri,
            $body,
            $headers,
            $files,
            $uriParams
        );
    }
}
