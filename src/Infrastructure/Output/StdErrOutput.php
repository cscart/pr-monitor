<?php
declare(strict_types=1);

namespace CsCart\PrMonitor\Infrastructure\Output;

use CsCart\PrMonitor\Infrastructure\OutputInterface;

class StdErrOutput implements OutputInterface
{
    public function write(string $line)
    {
        file_put_contents('php://stderr', $line);
    }

    public function writeLine(string $line)
    {
        $this->write("{$line}\n");
    }
}
