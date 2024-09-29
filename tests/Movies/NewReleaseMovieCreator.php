<?php

declare(strict_types=1);

namespace Tests\Movies;

use RevoTest\Movies\Movie;

final readonly class NewReleaseMovieCreator extends MovieCreator
{
    public function create(): Movie
    {
        return new Movie($this->faker->name(), Movie::NEW_RELEASE);
    }
}