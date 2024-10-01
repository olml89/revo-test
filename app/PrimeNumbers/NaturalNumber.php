<?php

declare(strict_types=1);

namespace RevoTest\PrimeNumbers;

use InvalidArgumentException;
use Stringable;

final readonly class NaturalNumber implements Stringable
{
    private function __construct(
        public int $value,
    ) {}

    public static function fromInt(int $int): self
    {
        if ($int <= 0) {
            throw new InvalidArgumentException('Input must be a natural number.');
        }

        return new self($int);
    }

    public static function fromConsole(false|string $input): self
    {
        if (filter_var($input, FILTER_VALIDATE_INT) === false) {
            throw new InvalidArgumentException('Input must be a natural number.');
        }

        return self::fromInt((int)$input);
    }

    public function __toString(): string
    {
        return (string)$this->value;
    }
}