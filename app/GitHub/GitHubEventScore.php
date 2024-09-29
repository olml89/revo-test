<?php

declare(strict_types=1);

namespace RevoTest\GitHub;

final class GitHubEventScore
{
    private const int DEFAULT_SCORE = 1;

    public function __construct(
        public int $score,
    ) {}

    public static function fromData(array $data): self
    {
        if (!array_key_exists('type', $data)) {
            return new self(0);
        }

        return new self(
            ScoredGitHubEventType::tryFrom($data['type'])?->toScore() ?? self::DEFAULT_SCORE,
        );
    }
}