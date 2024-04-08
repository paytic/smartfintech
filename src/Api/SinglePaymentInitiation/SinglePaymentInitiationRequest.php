<?php

namespace Paytic\Smartfintech\Api\SinglePaymentInitiation;

use Paytic\Smartfintech\Api\AbstractBase\AbstractRequestWithToken;
use Paytic\Smartfintech\HttpClient\RequestManager;

class SinglePaymentInitiationRequest extends AbstractRequestWithToken
{
    public const PATH = '/core/rest/api/initPayment';

    public const METHOD = 'POST';

    public ?int $paymentId = null;

    public ?string $creditorName = null;

    public ?string $creditorIban = null;
    public ?float $amount = null;

    public ?string $details = null;

    public ?string $psuEmail = null;

    public ?string $psuIntermediarId = null;

    public ?string $redirectURL = null;

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
        return $this->sendPost(
            $manager,
            null,
            json_encode($this->getBodyParams()),
        );
    }

    protected function getBodyParams()
    {
        return [
            'creditorName' => $this->creditorName,
            'creditorIban' => $this->creditorIban,
            'amount' => $this->amount,
            'details' => $this->details,
            'psuEmail' => $this->psuEmail,
            'psuIntermediarId' => $this->psuIntermediarId,
            'redirectURL' => $this->redirectURL,
        ];
    }
    public function getHeaders(): array
    {
        $headers = parent::getHeaders();
        $headers['Content-Type'] = 'application/json';
        return $headers;
    }
    protected function generateResponseClass(): string
    {
        return SinglePaymentInitiationResponse::class;
    }

}
