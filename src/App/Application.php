<?php
declare(strict_types=1);

namespace CsCart\PrMonitor\App;

use CsCart\PrMonitor\Domain\Service\PullRequestService;
use CsCart\PrMonitor\Domain\ValueObject\PullRequest\PullRequest;
use CsCart\PrMonitor\Domain\ValueObject\PullRequest\State;

class Application
{
    private PullRequestService $pullRequestService;

    private ReportServiceInterface $reportService;

    private string $pullRequestMessage;

    private string $commitStateContext = 'PR monitor';

    public function __construct(
        PullRequestService $pullRequestService,
        ReportServiceInterface $reportService,
        string $pullRequestMessage,
        string $commitStateContext = null
    ) {
        $this->pullRequestService = $pullRequestService;
        $this->reportService = $reportService;
        $this->pullRequestMessage = $pullRequestMessage;

        if ($commitStateContext !== null) {
            $this->commitStateContext = $commitStateContext;
        }
    }

    public function getPullRequestNumbers(int $perPage = 100): array
    {
        return $this->pullRequestService->getNumbers($perPage);
    }

    private function getPullRequest(int $pullRequestNumber): PullRequest
    {
        return $this->pullRequestService->getOne($pullRequestNumber);
    }

    private function markPullRequestConflict(PullRequest $pullRequest): bool
    {
        $this->pullRequestService->addMessage($pullRequest->getNumber(), $this->pullRequestMessage);

        return $this->pullRequestService->setStatus(
            $pullRequest->getHeadCommitHash(),
            State::createError($this->commitStateContext, $this->pullRequestMessage)
        );
    }

    public function processPullRequestState(int $pullRequestNumber)
    {
        $pullRequest = $this->getPullRequest($pullRequestNumber);

        $this->reportService->reportPullRequestState($pullRequest);

        if (!$pullRequest->isMergeable() && !$pullRequest->getState()->isError()) {
            $this->markPullRequestConflict($pullRequest);
            $this->reportService->reportPullRequestMarkedConflict($pullRequest);
        }
    }
}
