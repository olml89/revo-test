<?php

declare(strict_types=1);

namespace Tests\GitHub;

use RevoTest\GitHub\DataProviders\GitHubEventsDataProvider;

final readonly class FakeGitHubEventsDataProvider implements GitHubEventsDataProvider
{
    public function __construct(
        private array $githubEvents,
    ) {}

    public function getData(string $user): array
    {
        return $this->githubEvents;
    }
}