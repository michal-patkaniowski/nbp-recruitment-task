<?php

declare(strict_types=1);

namespace App\Nbp\Entity;

use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Serializer\Annotation\SerializedName;

final class NbpApiDataModel
{
    public const GROUP_AVERAGE = 'GROUP_EXCHANGE_RATE_AVERAGE';
    private string $table;
    private string $currency;
    private string $code;
    private array $rates;

    public function getTable(): string
    {
        return $this->table;
    }

    public function setTable(string $table): self
    {
        $this->table = $table;
        return $this;
    }

    public function getCurrency(): ?string
    {
        return $this->currency;
    }

    public function setCurrency(?string $currency): self
    {
        $this->currency = $currency;
        return $this;
    }

    public function getCode(): string
    {
        return $this->code;
    }

    public function setCode(string $code): self
    {
        $this->code = $code;
        return $this;
    }

    /**
     * @return NbpApiDataModelRate[]
     */
    public function getRates(): array
    {
        return $this->rates;
    }

    public function setRates(array $rates): self
    {
        $this->rates = $rates;
        return $this;
    }

    #[Groups([self::GROUP_AVERAGE]), SerializedName('average_price')]
    public function getAverageRate(): float
    {
        $rateVals = array_map(static fn($item) => $item->getBid(), $this->rates);
        return round(array_sum($rateVals) / count($rateVals), 4);
    }
}
