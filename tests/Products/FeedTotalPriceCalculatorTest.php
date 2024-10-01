<?php

declare(strict_types=1);

namespace Tests\Products;

use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\CoversTrait;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;
use RevoTest\Products\Feeds\JsonFeed;
use RevoTest\Products\FeedTotalPriceCalculator;
use RevoTest\Products\Product;
use RevoTest\Products\Type;
use RevoTest\Products\ValidatesKeys;
use RevoTest\Products\Variant;

#[CoversClass(FeedTotalPriceCalculator::class)]
#[CoversClass(JsonFeed::class)]
#[CoversClass(Product::class)]
#[CoversClass(Variant::class)]
#[CoversTrait(ValidatesKeys::class)]
final class FeedTotalPriceCalculatorTest extends TestCase
{
    public static function provideExpectedPriceAndAllowedTypes(): array
    {
        return [
            /**
             * The collections-2.json fixture file contains 3 products:
             * 1) Wallets with variants Blue = 29.33, Turquoise = 18.50
             * 2) Shoes with variant Sky Blue = 20 (not taken into account)
             * 3) Lamps with variants Blasverk = 9.99, Tarnaby = 15, Fado = 19.99
             */
            [
                47.83,
                Type::Wallet,
            ],
            [
                20,
                Type::Shoes,
            ],
            [
                44.98,
                Type::Lamp,
            ],
            [
                67.83,
                Type::Wallet,
                Type::Shoes,
            ],
            [
                92.81,
                Type::Wallet,
                Type::Lamp,
            ],
            [
                64.98,
                Type::Shoes,
                Type::Lamp,
            ],
            [
                112.81,
                Type::Wallet,
                Type::Shoes,
                Type::Lamp,
            ],
        ];
    }

    #[DataProvider('provideExpectedPriceAndAllowedTypes')]
    public function testItProperlyCalculatesTheTotalPrice(float $expectedPrice, Type ...$allowedTypes): void
    {
        $encodedJsonFeed = file_get_contents(__DIR__ . '/collections-2.json');
        $feed = JsonFeed::fromJson($encodedJsonFeed);
        $calculator = new FeedTotalPriceCalculator();

        $this->assertEquals($expectedPrice, $calculator->calculate($feed, ...$allowedTypes));
    }
}