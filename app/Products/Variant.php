<?php

declare(strict_types=1);

namespace RevoTest\Products;

use InvalidArgumentException;

final readonly class Variant
{
    use ValidatesKeys;

    public function __construct(
        public string $title,
        public float $price,
    ) {}

    /**
     * @throws InvalidArgumentException
     */
    public static function fromData(array $data): self
    {
        return new self(
            self::getData('title', $data),
            self::getData('price', $data),
        );
    }
}