<?php

declare(strict_types=1);

namespace Tests\Movies;

use RevoTest\Movies\Movie\RegularMovie;

final readonly class RegularMovieCreator extends MovieCreator
{
    public function create(): RegularMovie
    {
        return new RegularMovie($this->faker->name());
    }
}