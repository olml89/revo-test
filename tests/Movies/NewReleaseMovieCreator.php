<?php

declare(strict_types=1);

namespace Tests\Movies;

use RevoTest\Movies\Movie\NewReleaseMovie;

final readonly class NewReleaseMovieCreator extends MovieCreator
{
    public function create(): NewReleaseMovie
    {
        return new NewReleaseMovie($this->faker->name());
    }
}