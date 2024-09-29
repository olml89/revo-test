<?php

declare(strict_types=1);

namespace RevoTest\GitHub\DataProviders;

interface GitHubEventsDataProvider
{
    /**
     * @throws UnreachableGitHubEventsException
     */
    public function getData(string $user): array;
}