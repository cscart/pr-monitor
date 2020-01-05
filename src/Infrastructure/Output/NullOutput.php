<?php
declare(strict_types=1);

namespace CsCart\PrMonitor\Infrastructure\Output;

use CsCart\PrMonitor\Infrastructure\OutputInterface;

class NullOutput implements OutputInterface
{
    public function write(string $line)
    {
    }

    public function writeLine(string $line)
    {
    }
}
