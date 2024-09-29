<?php

declare(strict_types=1);

namespace RevoTest\GitHub\DataProviders;

use RuntimeException;

final class UnreachableGitHubEventsException extends RuntimeException
{
    private function __construct(string $message)
    {
        parent::__construct($message);
    }

    public static function unavailableUser(string $user): self
    {
        return new self(sprintf(
            'Unable to get events from Github user %s',
            $user,
        ));
    }

    public static function corruptJson(string $user): self
    {
        return new self(sprintf(
            'Corrupt json data on retrieval of events from Github user %s',
            $user,
        ));
    }
}