<?php

namespace Paytic\Smartfintech\Api\AbstractBase\Behaviours;

use Paytic\Smartfintech\Models\Contract;

trait RequestHasContract
{
    protected ?Contract $contract = null;

    protected static function validateParamContract(array $params = []): void
    {
        if (!isset($params['contract'])) {
            throw new \Exception('contract parameter must be a string');
        }
        if (!($params['contract'] instanceof Contract)) {
            throw new \Exception('platform parameter must be an instance of Contract');
        }
    }

    public function setContract(Contract $contract): void
    {
        $this->contract = $contract;
    }

    public function getContract(): ?Contract
    {
        return $this->contract;
    }
}

