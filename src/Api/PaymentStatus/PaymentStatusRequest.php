<?php

namespace Paytic\Smartfintech\Api\PaymentStatus;

use Paytic\Smartfintech\Api\AbstractBase\AbstractRequestWithToken;
use Paytic\Smartfintech\HttpClient\RequestManager;

class PaymentStatusRequest extends AbstractRequestWithToken
{
    public const PATH = '/core/rest/api/status';

    public const METHOD = 'GET';

    public ?int $paymentId = null;

    /**
     * @param int $paymentId
     */
    public function __construct(int $paymentId)
    {
        $this->paymentId = $paymentId;
    }

    protected static function createParseConstructorParams(array &$params = []): array
    {
        $constructorParams = parent::createParseConstructorParams($params);
        $paymentId = $params['paymentId'] ?? null;
        if (empty($paymentId)) {
            throw new \Exception("Missing paymentId");
        }
        unset($params['paymentId']);
        $constructorParams['paymentId'] = $paymentId;
        return $constructorParams;
    }

    public function getUri(): ?string
    {
        return parent::getUri() . '/' . $this->paymentId;
    }

    public function send(RequestManager $manager)
    {
        return $this->sendGet($manager);
    }

    public function getHeaders(): array
    {
        $headers = parent::getHeaders();
        $headers['Content-Type'] = 'application/json';
        return $headers;
    }

    protected function generateResponseClass(): string
    {
        return PaymentStatusResponse::class;
    }

}
