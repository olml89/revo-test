<?php

declare(strict_types=1);

namespace RevoTest\Movies;

use RevoTest\Movies\Movie\Movie;

final readonly class Rental
{
    public function __construct(
        public Movie $movie,
        public int $daysRented,
    ) {}
}