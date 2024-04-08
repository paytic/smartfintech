<?php

namespace Paytic\Smartfintech\HttpClient;

use Exception;
use finfo;
use Http\Client\Exception\TransferException;
use Http\Message\MultipartStream\MultipartStreamBuilder;
use Paytic\Smartfintech\Api\AbstractBase\AbstractResponse;
use Paytic\Smartfintech\Api\AbstractBase\BaseRequest;
use Paytic\Smartfintech\Api\AbstractBase\BaseResponse;
use Paytic\Smartfintech\Api\AbstractBase\ErrorResponse;
use Paytic\Smartfintech\HttpClient\Message\ResponseParser;
use Paytic\Smartfintech\HttpClient\Util\QueryStringBuilder;
use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\StreamFactoryInterface;
use Psr\Http\Message\StreamInterface;
use RuntimeException;
use function array_filter;
use function basename;
use function class_exists;
use function count;
use function fopen;
use function func_get_args;
use function restore_error_handler;
use function set_error_handler;
use function sprintf;
use const FILEINFO_MIME_TYPE;

class RequestManager
{

    /**
     * The URI prefix.
     *
     * @var string
     */
    private const URI_PREFIX = '/gateway';

    use HasClientBuilder;

    public function __construct(ClientBuilder $httpClientBuilder)
    {
        $this->httpClientBuilder = $httpClientBuilder;
    }

    public function sendApiRequest(BaseRequest $apiRequest): BaseResponse
    {
        try {
            if (method_exists($apiRequest, 'send')) {
                $httpResponse = $apiRequest->send($this);
            } else {
                $httpRequest = $this->prepareRequest($apiRequest);
                $httpResponse = $this->getHttpClientBuilder()->getHttpClient()->sendRequest($httpRequest);
            }
        } catch (TransferException $e) {
            throw new Exception('Error while requesting data from gateway: ' . $e->getMessage(), $e->getCode(), $e);
        }

        return $this->parseResponse($apiRequest, $httpResponse);
    }

    /**
     * @param string $uri
     * @param array<string,mixed> $params
     * @param array<string,string> $headers
     *
     * @return mixed
     */
    protected function get(string $uri, array $params = [], array $headers = [])
    {
        return $this->getHttpClientBuilder()->getHttpClient()->get(
            self::prepareUri($uri, $params),
            $headers
        );
    }

    /**
     * @param string $uri
     * @param array<string,mixed> $params
     * @param array<string,string> $headers
     * @param array<string,string> $files
     * @param array<string,mixed> $uriParams
     *
     * @return mixed
     */
    public function post(string $uri, array $params = [], array $headers = [], array $files = [], array $uriParams = [])
    {
        if (0 < count($files)) {
            $builder = $this->createMultipartStreamBuilder($params, $files);
//            $body = self::prepareMultipartBody($builder);
//            $headers = self::addMultipartContentType($headers, $builder);
        } else {
            $body = $this->generateBodyStreamFromData($params, $this->getHttpClientBuilder()->getStreamFactory());
        }

        return $this->getHttpClientBuilder()->getHttpClient()->post(
            self::prepareUri($uri, $uriParams),
            $headers,
            $body
        );
    }

    protected function prepareRequest(BaseRequest $request)
    {
        return $this->createRequest(
            $request->getMethod(),
            $request->getUri(),
            $request->getHeaders(),
            $this->createBody($request->getBody())
        );
    }

    /**
     * @param string $method
     * @param string $uri
     * @param array $headers
     * @param StreamInterface $stream
     * @return RequestInterface
     */
    protected function createRequest(string $method, string $uri, array $headers, StreamInterface $stream): RequestInterface
    {
        $request = $this->getHttpClientBuilder()->getRequestFactory()->createRequest($method, $uri);
        $request = $request->withBody($stream);
        foreach ($headers as $name => $value) {
            $request = $request->withAddedHeader($name, $value);
        }

        return $request;
    }

    /**
     * Prepare the request URI.
     *
     * @param string $uri
     * @param array $query
     *
     * @return string
     */
    private static function prepareUri(string $uri, array $query = []): string
    {
        $query = array_filter($query, function ($value): bool {
            return null !== $value;
        });

        return sprintf('%s%s%s', self::URI_PREFIX, $uri, QueryStringBuilder::build($query));
    }


    protected function generateBodyStreamFromData($bodyData = null, StreamFactoryInterface $streamFactory = null)
    {
        if ($bodyData == null) {
            return null;
        }
        if ($streamFactory && is_array($bodyData)) {
            return $streamFactory->createStream(http_build_query($bodyData));
        }
        return null;
    }

    /**
     * Prepare the request URI.
     *
     * @param array<string,mixed> $params
     * @param array<string,string> $files
     *
     * @return MultipartStreamBuilder
     */
    private function createMultipartStreamBuilder(array $params = [], array $files = []): MultipartStreamBuilder
    {
        $builder = new MultipartStreamBuilder($this->getHttpClientBuilder()->getStreamFactory());

        foreach ($params as $name => $value) {
            $builder->addResource($name, $value);
        }

        foreach ($files as $name => $file) {
            $builder->addResource($name, self::tryFopen($file, 'r'), [
                'headers' => [
                    ResponseParser::CONTENT_TYPE_HEADER => self::guessFileContentType($file),
                ],
                'filename' => basename($file),
            ]);
        }

        return $builder;
    }

    /**
     * Safely opens a PHP stream resource using a filename.
     *
     * When fopen fails, PHP normally raises a warning. This function adds an
     * error handler that checks for errors and throws an exception instead.
     *
     * @param string $filename File to open
     * @param string $mode Mode used to open the file
     *
     * @return resource
     *
     * @throws RuntimeException if the file cannot be opened
     *
     * @see https://github.com/guzzle/psr7/blob/1.6.1/src/functions.php#L287-L320
     */
    private static function tryFopen(string $filename, string $mode)
    {
        $ex = null;
        set_error_handler(function () use ($filename, $mode, &$ex): void {
            $ex = new RuntimeException(sprintf(
                'Unable to open %s using mode %s: %s',
                $filename,
                $mode,
                func_get_args()[1]
            ));
        });

        $handle = fopen($filename, $mode);
        restore_error_handler();

        if (null !== $ex) {
            throw $ex;
        }

        /** @var resource */
        return $handle;
    }

    protected function parseResponse(BaseRequest $request, $httpResponse): AbstractResponse
    {
        $responseClass  = ($httpResponse->getStatusCode() != 200)
            ? ErrorResponse::class
            : $request->getResponseClass();
        $responseParser  = new ResponseParser($httpResponse, $responseClass);
        return $responseParser->parse();
    }

    /**
     * Guess the content type of the file if possible.
     *
     * @param string $file
     *
     * @return string
     */
    private static function guessFileContentType(string $file): string
    {
        if (!class_exists(finfo::class, false)) {
            return ResponseParser::STREAM_CONTENT_TYPE;
        }

        $finfo = new finfo(FILEINFO_MIME_TYPE);
        $type = $finfo->file($file);

        return false !== $type ? $type : ResponseParser::STREAM_CONTENT_TYPE;
    }
}