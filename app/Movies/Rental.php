<?php

declare(strict_types=1);

namespace RevoTest\Movies;

use RevoTest\Movies\Movie\Movie;

final readonly class Rental
{
    public function __construct(
        private Movie $movie,
        private int $daysRented,
    ) {}

    public function getMovie(): Movie
    {
        return $this->movie;
    }

    public function getDaysRented(): int
    {
        return $this->daysRented;
    }
}