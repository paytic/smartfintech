<?php

namespace Paytic\Smartfintech\HttpClient\Message;

use Paytic\Smartfintech\Api\AbstractBase\AbstractResponse;
use Psr\Http\Message\ResponseInterface;
use Symfony\Component\PropertyInfo\Extractor\ReflectionExtractor;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Serializer;

class ResponseParser
{
    /**
     * The content type header.
     *
     * @var string
     */
    public const CONTENT_TYPE_HEADER = 'Content-Type';

    /**
     * The octet stream content type identifier.
     *
     * @var string
     */
    public const STREAM_CONTENT_TYPE = 'application/octet-stream';

    /**
     * The multipart form data content type identifier.
     *
     * @var string
     */
    public const MULTIPART_CONTENT_TYPE = 'multipart/form-data';

    protected ResponseInterface $httpResponse;

    protected string $responseClass;

    protected ?AbstractResponse $apiResponse = null;
    protected Serializer $serializer;

    public function __construct(ResponseInterface $httpResponse, string $responseClass)
    {
        $this->httpResponse = $httpResponse;
        $this->responseClass = $responseClass;

        $encoders = [new JsonEncoder()];

        $normalizer = new ObjectNormalizer(null, null, null, new ReflectionExtractor());
        $normalizers = [$normalizer];

        $this->serializer = new Serializer($normalizers, $encoders);
    }

    public function parse(): AbstractResponse
    {
        $this->parseHttpResponseBody();
        $this->parseHttpResponse();
        return $this->apiResponse;
    }

    protected function parseHttpResponse(): void
    {
        $this->apiResponse->status = $this->httpResponse->getStatusCode();
        if (method_exists($this->apiResponse, 'populateFromHttpResponse')) {
            $this->apiResponse->populateFromHttpResponse($this->httpResponse);
        }
    }

    protected function parseHttpResponseBody(): void
    {
        $body = $this->httpResponse->getBody()->getContents();
        if ($body === null) {
            return;
        }
        $this->apiResponse = $this->serializer->deserialize($body, $this->responseClass, 'json');

        if (method_exists($this->apiResponse, 'populateFromHttpResponseBody')) {
            $this->apiResponse->populateFromHttpResponseBody($body);
        }
    }

    public function getApiResponse(): AbstractResponse
    {
        if ($this->apiResponse === null) {
            $this->initApiResponse();
        }
        return $this->apiResponse;
    }

    protected function initApiResponse(): void
    {
        $this->apiResponse = new $this->responseClass();
    }
}

