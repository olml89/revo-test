<?php

declare(strict_types=1);

namespace Tests\Movies;

use Faker\Generator;
use RevoTest\Movies\Movie\Movie;

abstract readonly class MovieCreator
{
    public function __construct(
        protected Generator $faker,
    ) {}

    abstract public function create(): Movie;
}