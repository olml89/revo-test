<?php

declare(strict_types=1);

namespace RevoTest\PrimeNumbers;

use InvalidArgumentException;

final readonly class NumberInputReader
{
    private function __construct(
        public int $number,
    ) {}

    public static function fromConsole(false|string $input): self
    {
        if (filter_var($input, FILTER_VALIDATE_INT) === false) {
            throw new InvalidArgumentException('Input must be an integer.');
        }

        return new self((int)$input);
    }
}