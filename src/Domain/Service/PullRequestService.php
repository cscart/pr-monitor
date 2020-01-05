<?php
declare(strict_types=1);

namespace CsCart\PrMonitor\Domain\Service;

use CsCart\PrMonitor\Domain\Github\ClientAdapterInterface;
use CsCart\PrMonitor\Domain\ValueObject\PullRequest\PullRequest;
use CsCart\PrMonitor\Domain\ValueObject\PullRequest\State;

class PullRequestService
{
    private ClientAdapterInterface $client;

    public function __construct(ClientAdapterInterface $client)
    {
        $this->client = $client;
    }

    public function getNumbers(int $perPage): array
    {
        return $this->client->getPullRequestNumbers(
            [
                'sort'      => 'updated',
                'state'     => 'open',
                'direction' => 'desc',
                'per_page'  => $perPage,
            ]
        );
    }

    public function getOne(int $number): PullRequest
    {
        return $this->client->getPullRequest($number);
    }

    public function setStatus(string $reference, State $state): bool
    {
        return $this->client->setCommitStatus($reference, $state);
    }

    public function addMessage(int $number, string $message): bool
    {
        return $this->client->addPullRequestMessage($number, $message);
    }
}
