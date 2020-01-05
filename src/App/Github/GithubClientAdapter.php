<?php
declare(strict_types=1);

namespace CsCart\PrMonitor\App\Github;

use Github\Client;
use CsCart\PrMonitor\Domain\Github\ClientAdapterInterface;
use CsCart\PrMonitor\Domain\ValueObject\PullRequest\PullRequest;
use CsCart\PrMonitor\Domain\ValueObject\PullRequest\State;
use CsCart\PrMonitor\Domain\ValueObject\Repository;

class GithubClientAdapter implements ClientAdapterInterface
{
    private Client $client;

    private Repository $repository;

    public function __construct(Client $client, Repository $repository)
    {
        $this->client = $client;
        $this->repository = $repository;
    }

    public function getPullRequestNumbers(array $parameters): array
    {
        $pullRequests = $this->client->pullRequests()->all(
            $this->repository->getOwner(),
            $this->repository->getName(),
            $parameters
        );

        return array_column($pullRequests, 'number');
    }

    public function getPullRequest(int $number): PullRequest
    {
        $pullRequestData = $this->client->pullRequest()->show(
            $this->repository->getOwner(),
            $this->repository->getName(),
            $number
        );

        $statuses = $this->client->pullRequest()->status(
            $this->repository->getOwner(),
            $this->repository->getName(),
            $number
        );

        if (!$statuses) {
            $state = State::createPending();
        } else {
            $lastStatus = reset($statuses);
            $state = new State($lastStatus['state']);
        }

        return new PullRequest(
            $number,
            $pullRequestData['head']['sha'],
            $state,
            (bool) $pullRequestData['mergeable'],
            $pullRequestData['html_url'],
            $pullRequestData['title']
        );
    }

    public function setCommitStatus(string $reference, State $state): bool
    {
        $this->client->repository()->statuses()->create(
            $this->repository->getOwner(),
            $this->repository->getName(),
            $reference,
            [
                'state'       => $state->getStateId(),
                'context'     => $state->getContext(),
                'description' => $state->getDescription(),
            ]
        );

        return true;
    }

    public function addPullRequestMessage(int $number, string $message): bool
    {
        $this->client->pullRequest()->reviews()->create(
            $this->repository->getOwner(),
            $this->repository->getName(),
            $number,
            [
                'body'  => $message,
                'event' => 'COMMENT',
            ]
        );

        return true;
    }
}
