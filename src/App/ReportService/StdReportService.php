<?php
declare(strict_types=1);

namespace CsCart\PrMonitor\App\ReportService;

use CsCart\PrMonitor\App\ReportServiceInterface;
use CsCart\PrMonitor\Domain\ValueObject\PullRequest\PullRequest;
use CsCart\PrMonitor\Infrastructure\Output\StdErrOutput;
use CsCart\PrMonitor\Infrastructure\Output\StdOutOutput;
use CsCart\PrMonitor\Infrastructure\OutputInterface;
use Throwable;

class StdReportService implements ReportServiceInterface
{
    private OutputInterface $progressOutput;

    private OutputInterface $errorOutput;

    private string $mergeableIndicator = '✅';

    private string $unmergeableIndicator = '🛑';

    private string $markedIndicator = '🛠';

    private string $errorIndicator = '⚠️';

    public function __construct(
        OutputInterface $progressOutput = null,
        OutputInterface $errorOutput = null,
        string $mergeableIndicator = null,
        string $unmergeableIndicator = null,
        string $markedIndicator = null,
        string $errorIndicator = null
    ) {
        if ($progressOutput === null) {
            $progressOutput = new StdOutOutput();
        }
        /** @var OutputInterface $progressOutput */
        $this->progressOutput = $progressOutput;

        if ($errorOutput === null) {
            $errorOutput = new StdErrOutput();
        }
        /** @var OutputInterface $errorOutput */
        $this->errorOutput = $errorOutput;

        if ($mergeableIndicator !== null) {
            $this->mergeableIndicator = $mergeableIndicator;
        }
        if ($unmergeableIndicator !== null) {
            $this->unmergeableIndicator = $unmergeableIndicator;
        }
        if ($markedIndicator !== null) {
            $this->markedIndicator = $markedIndicator;
        }
        if ($errorIndicator !== null) {
            $this->errorIndicator = $errorIndicator;
        }
    }

    public function reportError(Throwable $error)
    {
        $this->errorOutput->writeLine(
            sprintf(
                '%s (%s) %s',
                $this->errorIndicator,
                get_class($error),
                $error->getMessage()
            )
        );
    }

    public function reportPullRequestState(PullRequest $pullRequest)
    {
        $this->progressOutput->writeLine(
            sprintf(
                '%s %s %s',
                $pullRequest->isMergeable()
                    ? $this->mergeableIndicator
                    : $this->unmergeableIndicator,
                $pullRequest->getUrl(),
                $pullRequest->getTitle()
            )
        );
    }

    public function reportPullRequestMarkedConflict(PullRequest $pullRequest)
    {
        $this->progressOutput->writeLine(
            sprintf(
                '%s %s %s',
                $this->markedIndicator,
                $pullRequest->getUrl(),
                $pullRequest->getTitle()
            )
        );
    }
}
