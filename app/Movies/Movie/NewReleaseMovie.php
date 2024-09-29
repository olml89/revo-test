<?php

declare(strict_types=1);

namespace RevoTest\Movies\Movie;

final readonly class NewReleaseMovie extends AbstractMovie implements Movie
{
    public function getAmount(int $daysRented): float
    {
        return $daysRented * 3;
    }

    public function getFrequentRenderPoints(int $daysRented): int
    {
        return $daysRented > 1
            ? 1
            : 0;
    }
}