<?php

declare(strict_types=1);

namespace RevoTest\Products;

use InvalidArgumentException;

final readonly class Product
{
    use ValidatesKeys;

    /**
     * @var Variant[]
     */
    private array $variants;

    public function __construct(
        public string $title,
        private Type $type,
        Variant ...$variants,
    ) {
        $this->variants = $variants;
    }

    /**
     * @throws InvalidArgumentException
     */
    public static function fromData(array $data): self
    {
        return new self(
            self::getData('title', $data),
            Type::from(self::getData('product_type', $data)),
            ...array_map(
                fn(array $variantData): Variant => Variant::fromData($variantData),
                self::getData('variants', $data),
            ),
        );
    }

    public function getTotalPrice(Type ...$allowedTypes): float
    {
        if (!in_array($this->type, $allowedTypes)) {
            return 0.0;
        }

        return array_reduce(
            array: $this->variants,
            callback: fn(float $carry, Variant $variant): float => $carry + $variant->price,
            initial: 0.0,
        );
    }
}