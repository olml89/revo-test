<?php

declare(strict_types=1);

namespace RevoTest\GitHub;

enum ScoredGitHubEventType: string
{
    case PushEvent = 'PushEvent';
    case CreateEvent = 'CreateEvent';
    case IssuesEvent = 'IssuesEvent';
    case CommitCommentEvent = 'CommitCommentEvent';

    public function toScore(): int
    {
        return match ($this) {
            self::PushEvent => 5,
            self::CreateEvent => 4,
            self::IssuesEvent => 3,
            self::CommitCommentEvent => 2,
        };
    }
}
