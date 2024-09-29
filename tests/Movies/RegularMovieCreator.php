<?php

declare(strict_types=1);

namespace Tests\Movies;

use RevoTest\Movies\Movie;

final readonly class RegularMovieCreator extends MovieCreator
{
    public function create(): Movie
    {
        return new Movie($this->faker->name(), Movie::REGULAR);
    }
}