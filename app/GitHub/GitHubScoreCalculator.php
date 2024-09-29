<?php

declare(strict_types=1);

namespace RevoTest\GitHub;

use RevoTest\GitHub\DataProviders\GitHubEventsDataProvider;
use RevoTest\GitHub\DataProviders\UnreachableGitHubEventsException;

final readonly class GitHubScoreCalculator
{
    public function __construct(
        private GitHubEventsDataProvider $dataProvider,
    ) {}

    /**
     * @throws UnreachableGitHubEventsException
     */
    public function calculate(string $user): int
    {
        return array_reduce(
            array: $this->dataProvider->getData($user),
            callback: fn(int $carry, array $eventData): int => $carry + GitHubEventScore::fromData($eventData)->score,
            initial: 0,
        );
    }
}