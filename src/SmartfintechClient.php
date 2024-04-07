<?php

namespace Paytic\Smartfintech;


class SmartfintechClient
{
    use Client\HasApiEndpoints;
    use Client\HasHttpClientTrait;
    use Client\HasRequestsTrait;

    public const SANDBOX_URL = 'https://mtls.sandbox.pay.smartfintech.eu';

    public const LIVE_URL = 'https://mtls.pay.smartfintech.eu';

    protected $isSandbox = true;

    public function isSandbox(bool $isSandbox = null)
    {
        if ($isSandbox === null) {
            return $this->isSandbox;
        }
        $this->isSandbox = $isSandbox;
        $this->initBaseUrl();
        return $isSandbox;
    }

}
