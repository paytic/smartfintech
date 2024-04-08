<?php

namespace Paytic\Smartfintech\Api\AbstractBase;

use Psr\Http\Message\ResponseInterface;

class AbstractResponse
{
    public string $messageStatus;
    public int $status;

}
