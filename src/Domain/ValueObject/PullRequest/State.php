<?php
declare(strict_types=1);

namespace CsCart\PrMonitor\Domain\ValueObject\PullRequest;

class State
{
    const ERROR = 'error';
    const FAILURE = 'failure';
    const PENDING = 'pending';
    const SUCCESS = 'success';

    private string $stateId;

    private string $context;

    private string $description;

    public function __construct(string $stateId, string $context = 'default', string $description = '')
    {
        if (!in_array($stateId, [self::ERROR, self::FAILURE, self::PENDING, self::SUCCESS])) {
            throw new \Exception('Unknown state ' . $stateId);
        }

        $this->stateId = $stateId;
        $this->context = $context;
        $this->description = $description;
    }

    public static function createError(string $context = 'default', string $description = ''): self
    {
        return new static(self::ERROR, $context, $description);
    }

    public static function createFailure(string $context = 'default', string $description = ''): self
    {
        return new static(self::FAILURE, $context, $description);
    }

    public static function createPending(string $context = 'default', string $description = ''): self
    {
        return new static(self::PENDING, $context, $description);
    }

    public static function createSuccess(string $context = 'default', string $description = ''): self
    {
        return new static(self::SUCCESS, $context, $description);
    }

    public function isEqual(State $state): bool
    {
        return $this->getStateId() === $state->getStateId();
    }

    public function getStateId(): string
    {
        return $this->stateId;
    }

    public function isError(): bool
    {
        return $this->isEqual(static::createError());
    }

    public function getContext(): string
    {
        return $this->context;
    }

    public function getDescription(): string
    {
        return $this->description;
    }
}
