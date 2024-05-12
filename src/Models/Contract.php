<?php

namespace Paytic\Smartfintech\Models;

class Contract
{
    protected ?string $name = null;
    protected ?string $cifCnp = null;
    protected ?string $tradeRegisterNumber = null;
    protected ?string $officeAddress = null;
    protected ?string $county = null;

    protected ?string $bank = null;
    protected ?string $iban = null;
    protected ?string $contactPerson = null;
    protected ?string $contactEmail = null;

    protected ?string $contactPhone = null;

    protected ?string $role = null;

    protected bool $vatPayer = false;

    protected ?int $vatRate = 0;

    protected bool $nonpayingVAT = false;
    protected ?string $persAcceptTCSF = null;
    protected \DateTime|null $dataAcceptTCSF = null;
    protected ?string $correspondanceAddress = null;

    protected ?string $platformURL = null;
    protected ?string $logo = null;

    public static function create(array $data = []): self
    {
        return new self($data);
    }

    public function __construct(array $data = [])
    {
        $this->dataAcceptTCSF = new \DateTime();

        foreach ($data as $key => $value) {
            $method = 'set' . str_replace('_', '', ucwords($key, '_'));
            if (method_exists($this, $method)) {
                $this->$method($value);
            } elseif (property_exists($this, $key)) {
                $this->$key = $value;
            }
        }
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(?string $name): void
    {
        $this->name = $name;
    }

    public function getCifCnp(): ?string
    {
        return $this->cifCnp;
    }

    public function setCifCnp(?string $cifCnp): void
    {
        $this->cifCnp = $cifCnp;
    }

    public function getTradeRegisterNumber(): ?string
    {
        return $this->tradeRegisterNumber;
    }

    public function setTradeRegisterNumber(?string $tradeRegisterNumber): void
    {
        $this->tradeRegisterNumber = $tradeRegisterNumber;
    }

    public function getOfficeAddress(): ?string
    {
        return $this->officeAddress;
    }

    public function setOfficeAddress(?string $officeAddress): void
    {
        $this->officeAddress = $officeAddress;
    }

    public function getCounty(): ?string
    {
        return $this->county;
    }

    public function setCounty(?string $county): void
    {
        $this->county = $county;
    }

    public function getBank(): ?string
    {
        return $this->bank;
    }

    public function setBank(?string $bank): void
    {
        $this->bank = $bank;
    }

    public function getIban(): ?string
    {
        return $this->iban;
    }

    public function setIban(?string $iban): void
    {
        $this->iban = $iban;
    }

    public function getContactPerson(): ?string
    {
        return $this->contactPerson;
    }

    public function setContactPerson(?string $contactPerson): void
    {
        $this->contactPerson = $contactPerson;
    }

    public function getContactEmail(): ?string
    {
        return $this->contactEmail;
    }

    public function setContactEmail(?string $contactEmail): void
    {
        $this->contactEmail = $contactEmail;
    }

    public function getContactPhone(): ?string
    {
        return $this->contactPhone;
    }

    public function setContactPhone(?string $contactPhone): void
    {
        $this->contactPhone = $contactPhone;
    }

    public function getRole(): ?string
    {
        return $this->role;
    }

    public function setRole(?string $role): void
    {
        $this->role = $role;
    }

    public function isVatPayer(): bool
    {
        return $this->vatPayer;
    }

    public function setVatPayer(bool $vatPayer): void
    {
        $this->vatPayer = $vatPayer;
    }

    public function getVatRate(): ?int
    {
        return $this->vatRate;
    }

    public function setVatRate(?int $vatRate): void
    {
        $this->vatRate = $vatRate;
    }

    public function isNonpayingVAT(): bool
    {
        return $this->nonpayingVAT;
    }

    public function setNonpayingVAT(bool $nonpayingVAT): void
    {
        $this->nonpayingVAT = $nonpayingVAT;
    }

    public function getPersAcceptTCSF(): ?string
    {
        return $this->persAcceptTCSF;
    }

    public function setPersAcceptTCSF(?string $persAcceptTCSF): void
    {
        $this->persAcceptTCSF = $persAcceptTCSF;
    }

    public function getDataAcceptTCSF(): ?\DateTime
    {
        return $this->dataAcceptTCSF;
    }

    public function setDataAcceptTCSF(?\DateTime $dataAcceptTCSF): void
    {
        $this->dataAcceptTCSF = $dataAcceptTCSF;
    }

    public function getCorrespondanceAddress(): ?string
    {
        return $this->correspondanceAddress;
    }

    public function setCorrespondanceAddress(?string $correspondanceAddress): void
    {
        $this->correspondanceAddress = $correspondanceAddress;
    }

    public function getPlatformURL(): ?string
    {
        return $this->platformURL;
    }

    public function setPlatformURL(?string $platformURL): void
    {
        $this->platformURL = $platformURL;
    }

    public function getLogo(): ?string
    {
        return $this->logo;
    }

    public function setLogo(?string $logo): void
    {
        $this->logo = $logo;
    }

    public function toArray(): array
    {
        return [
            'name' => $this->name,
            'cifCnp' => $this->cifCnp,
            'tradeRegisterNumber' => $this->tradeRegisterNumber,
            'officeAddress' => $this->officeAddress,
            'county' => $this->county,
            'bank' => $this->bank,
            'iban' => $this->iban,
            'contactPerson' => $this->contactPerson,
            'contactEmail' => $this->contactEmail,
            'contactPhone' => $this->contactPhone,
            'role' => $this->role,
            'vatPayer' => $this->vatPayer,
            'vatRate' => $this->vatRate,
            'nonpayingVAT' => $this->nonpayingVAT,
            'persAcceptTCSF' => $this->persAcceptTCSF,
            'dataAcceptTCSF' => $this->dataAcceptTCSF,
            'correspondanceAddress' => $this->correspondanceAddress,
            'platformURL' => $this->platformURL,
            'logo' => $this->logo,
        ];
    }
}