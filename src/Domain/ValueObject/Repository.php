<?php
declare(strict_types=1);

namespace CsCart\PrMonitor\Domain\ValueObject;

class Repository
{
    private string $owner;

    private string $name;

    public function __construct(string $owner, string $name)
    {
        $this->owner = $owner;
        $this->name = $name;
    }

    public function getOwner(): string
    {
        return $this->owner;
    }

    public function getName(): string
    {
        return $this->name;
    }
}
