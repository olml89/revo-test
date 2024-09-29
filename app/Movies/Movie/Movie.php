<?php

declare(strict_types=1);

namespace RevoTest\Movies\Movie;

interface Movie
{
    public function getTitle(): string;
    public function getAmount(int $daysRented): float;
    public function getFrequentRenderPoints(int $daysRented): int;
}