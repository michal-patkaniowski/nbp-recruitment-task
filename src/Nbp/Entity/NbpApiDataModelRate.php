<?php

declare(strict_types=1);

namespace App\Nbp\Entity;

final class NbpApiDataModelRate
{
    private string $no;
    private string $effectiveDate;
    private float $bid;
    private float $ask;

    public function getNo(): string
    {
        return $this->no;
    }

    public function setNo(string $no): self
    {
        $this->no = $no;
        return $this;
    }

    public function getEffectiveDate(): string
    {
        return $this->effectiveDate;
    }

    public function setEffectiveDate(string $effectiveDate): self
    {
        $this->effectiveDate = $effectiveDate;
        return $this;
    }

    public function getBid(): float
    {
        return $this->bid;
    }

    public function setBid(float $bid): self
    {
        $this->bid = $bid;
        return $this;
    }

    public function getAsk(): float
    {
        return $this->ask;
    }

    public function setAsk(float $ask): self
    {
        $this->ask = $ask;
        return $this;
    }
}
