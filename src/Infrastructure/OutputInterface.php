<?php
declare(strict_types=1);

namespace CsCart\PrMonitor\Infrastructure;

interface OutputInterface
{
    public function write(string $line);

    public function writeLine(string $line);
}
