<?php

declare(strict_types=1);

namespace RevoTest\Products\Feeds;

use JsonException;
use RevoTest\Products\Product;
use RevoTest\Products\ValidatesKeys;

final readonly class JsonFeed implements Feed
{
    use ValidatesKeys;

    /**
     * @var Product[]
     */
    private array $products;

    private function __construct(Product ...$products)
    {
        $this->products = $products;
    }

    /**
     * @throws JsonException
     */
    public static function fromJson(string $json): self
    {
        $rawFeed = json_decode($json, associative: true, flags: JSON_THROW_ON_ERROR);

        return new self(
            ...array_map(
                fn(array $productData): Product => Product::fromData($productData),
                self::getData('products', $rawFeed),
            ),
        );
    }

    public function toArray(): array
    {
        return $this->products;
    }
}