<?php

declare(strict_types=1);

namespace RevoTest\GitHub\DataProviders;

interface GitHubEventsDataProvider
{
    public function getData(string $user): array;
}