<?php

declare(strict_types=1);

namespace RevoTest\Movies\Movie;

abstract readonly class AbstractMovie implements Movie
{
    public function __construct(
        private string $title,
    ) {}

    public function getTitle(): string
    {
        return $this->title;
    }
}