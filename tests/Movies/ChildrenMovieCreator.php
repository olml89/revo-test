<?php

declare(strict_types=1);

namespace Tests\Movies;

use RevoTest\Movies\Movie\ChildrenMovie;

final readonly class ChildrenMovieCreator extends MovieCreator
{
    public function create(): ChildrenMovie
    {
        return new ChildrenMovie($this->faker->name());
    }
}