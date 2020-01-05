<?php
declare(strict_types=1);

namespace CsCart\PrMonitor\App;

use CsCart\PrMonitor\Domain\ValueObject\PullRequest\PullRequest;
use Throwable;

interface ReportServiceInterface
{
    public function reportError(Throwable $error);

    public function reportPullRequestState(PullRequest $pullRequest);

    public function reportPullRequestMarkedConflict(PullRequest $pullRequest);
}
