<?php

declare(strict_types=1);

namespace Tests\Movies;

use Faker\Generator;

abstract readonly class MovieCreator
{
    public function __construct(
        protected Generator $faker,
    ) {}
}