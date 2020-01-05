<?php
declare(strict_types=1);

namespace CsCart\PrMonitor\Domain\ValueObject\PullRequest;

class PullRequest
{
    private string $url;

    private string $title;

    private int $number;

    private string $headCommitHash;

    private State $state;

    private bool $isMergeable;

    public function __construct(
        int $number,
        string $headCommitHash,
        State $state,
        bool $isMergeable,
        string $url,
        string $title
    ) {
        $this->number = $number;
        $this->headCommitHash = $headCommitHash;
        $this->state = $state;
        $this->isMergeable = $isMergeable;
        $this->url = $url;
        $this->title = $title;
    }

    public function getNumber(): int
    {
        return $this->number;
    }

    public function getHeadCommitHash(): string
    {
        return $this->headCommitHash;
    }

    public function getState(): State
    {
        return $this->state;
    }

    public function isMergeable(): bool
    {
        return $this->isMergeable;
    }

    public function getUrl(): string
    {
        return $this->url;
    }

    public function getTitle(): string
    {
        return $this->title;
    }
}
