<?php

namespace Paytic\Smartfintech\Api\Client;

use Paytic\Smartfintech\Api\AbstractBase\AbstractRequest;
use Paytic\Smartfintech\Api\AbstractBase\Behaviours\RequestHasContract;
use Paytic\Smartfintech\Models\Contract;

class ContractDisplayRequest extends AbstractRequest
{
    use RequestHasContract;
    protected $platform = null;

    protected static function createValidateParams(array $params = []): void
    {
        parent::createValidateParams($params);
        if (!isset($params['platform'])) {
            throw new \Exception('platform parameter not set');
        }
        self::validateParamContract($params);
    }

    public function displayHtml(): string
    {
        return $this->generateIframe()
            . $this->generateScript();
    }

    public function generateIframe(): string
    {
        return '<iframe src="https://sandbox.pay.smartfintech.eu/' . $this->platform . '/contract"'
            . ' title="T&C"  id="my-iframe"'
            . ' style="width: 100%; height: 500px;border: 1px solid #cacaca">Loading contract ...</iframe>';
    }

    public function generateScript()
    {
        return '<script>
const intervalID = setInterval(
  () => {
    const iframe = document.getElementById("my-iframe").contentWindow;
    iframe.postMessage(' . $this->generateScriptData() . ', "*");
  }, 500);

window.addEventListener("message", (event) => {
    if (event.origin === "https://sandbox.pay.smartfintech.eu") {
        const data = event.data;
        if (data === "Received!") {clearInterval(intervalID);}
    }
});
</script>';
    }

    protected function generateScriptData(): bool|string
    {
        $data = [
            'Data_Curenta' => $this->contract->getDataAcceptTCSF()->format('d/m/y'),
            'Nume_Comerciant' => $this->contract->getName(),
            'Adresa_Sediu' => $this->contract->getOfficeAddress(),
            'Nr_Reg_Com' => $this->contract->getTradeRegisterNumber(),
            'CUI_CUF' => $this->contract->getCifCnp(),
            'IBAN' => $this->contract->getIban(),
            'Nume_Reprezentant' => $this->contract->getContactPerson(),
            'Calitate_Reprezentant' => $this->contract->getRole(),
            'Site_Platforma' => $this->contract->getPlatformURL(),
            'Adresa_Corespondenta' => $this->contract->getCorrespondanceAddress(),
            'Email_Corespondenta' => $this->contract->getContactEmail(),
        ];
        return json_encode($data);
    }
}

