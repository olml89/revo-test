<?php

declare(strict_types=1);

namespace RevoTest\Movies\Movie;

final readonly class ChildrenMovie extends AbstractMovie implements Movie
{
    public function getAmount(int $daysRented): float
    {
        $baseAmount = 1.5;

        return $daysRented > 2
            ? $baseAmount + (($daysRented - 3) * 1.5)
            : $baseAmount;
    }

    public function getFrequentRenderPoints(int $daysRented): int
    {
        return 0;
    }
}