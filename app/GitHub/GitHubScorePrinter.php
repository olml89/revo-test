<?php

declare(strict_types=1);

namespace RevoTest\GitHub;

use RevoTest\GitHub\DataProviders\UnreachableGitHubEventsException;

final readonly class GitHubScorePrinter
{
    public function __construct(
        private GitHubScoreCalculator $scoreCalculator,
    ) {}

    public function print(string $user): string
    {
        try {
            return sprintf(
                'Github score for user %s: %s points.%s',
                $user,
                $this->scoreCalculator->calculate($user),
                PHP_EOL,
            );
        }
        catch (UnreachableGitHubEventsException $e) {
            return sprintf(
                '%s.%s',
                $e->getMessage(),
                PHP_EOL,
            );
        }
    }
}