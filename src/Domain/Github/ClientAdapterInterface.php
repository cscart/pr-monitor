<?php
declare(strict_types=1);

namespace CsCart\PrMonitor\Domain\Github;

use CsCart\PrMonitor\Domain\ValueObject\PullRequest\PullRequest;
use CsCart\PrMonitor\Domain\ValueObject\PullRequest\State;

interface ClientAdapterInterface
{
    /**
     * @param array  $parameters
     *
     * @return int[]
     */
    public function getPullRequestNumbers(array $parameters): array;

    public function getPullRequest(int $number): PullRequest;

    public function setCommitStatus(string $reference, State $state): bool;

    public function addPullRequestMessage(int $number, string $message): bool;
}
