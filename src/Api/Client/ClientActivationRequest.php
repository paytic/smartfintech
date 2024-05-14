<?php

namespace Paytic\Smartfintech\Api\Client;

use Paytic\Smartfintech\Api\AbstractBase\AbstractRequest;
use Paytic\Smartfintech\Api\AbstractBase\Behaviours\RequestHasClientId;
use Paytic\Smartfintech\Api\AbstractBase\Behaviours\RequestHasContract;
use Paytic\Smartfintech\HttpClient\RequestManager;
use Paytic\Smartfintech\Models\Contract;

class ClientActivationRequest extends AbstractRequest
{
    use RequestHasContract;
    use RequestHasClientId;

    public const PATH = '/core/rest/api/clientActivation';


    protected static function createValidateParams(array $params = []): void
    {
        parent::createValidateParams($params);
        self::validateParamClientId($params);
        self::validateParamContract($params);
    }

    public function send(RequestManager $manager)
    {
        return $this->sendPost(
            $manager,
            null,
            json_encode($this->getBodyParams()),
        );
    }

    protected function getBodyParams(): array
    {
        $contract = $this->getContract();
        return [
            'name' => $contract->getName(),
            'cifCnp' => $contract->getCifCnp(),
            'tradeRegisterNumber' => $contract->getTradeRegisterNumber(),
            'officeAddress' => $contract->getOfficeAddress(),
            'county' => $contract->getCounty(),
            'bank' => $contract->getBank(),
            'iban' => $contract->getIban(),
            'contactPerson' => $contract->getContactPerson(),
            'contactEmail' => $contract->getContactEmail(),
            'contactPhone' => $contract->getContactPhone(),
            'vatPayer' => $contract->isVatPayer(),
            'vatRate' => $contract->getVatRate(),
            'nonpayingVAT' => $contract->isNonpayingVAT(),
            'persAcceptTCSF' => $contract->getPersAcceptTCSF(),
            'dataAcceptTCSF' => $contract->getDataAcceptTCSF()->format('Y-m-d\\TH:i:s'),
            'correspondanceAddress' => $contract->getCorrespondanceAddress(),
            'role' => $contract->getRole(),
            'platformURL' => $contract->getPlatformURL(),
            'logo' => $contract->getLogo(),
        ];
    }

    public function getHeaders(): array
    {
        $headers = parent::getHeaders();
        $headers['Content-Type'] = 'application/json';
        $headers['clientId'] = $this->getClientId();
        return $headers;
    }
}

