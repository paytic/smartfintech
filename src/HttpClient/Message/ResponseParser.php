<?php

namespace Paytic\Smartfintech\HttpClient\Message;

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
}

