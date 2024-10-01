<?php

declare(strict_types=1);

namespace Tests\Products;

use Faker\Factory;
use Faker\Generator;
use InvalidArgumentException;
use JsonException;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;
use RevoTest\Products\Feeds\JsonFeed;
use RevoTest\Products\Product;
use RevoTest\Products\Type;
use RevoTest\Products\Variant;

#[CoversClass(JsonFeed::class)]
#[CoversClass(Product::class)]
#[CoversClass(Variant::class)]
final class JsonFeedTest extends TestCase
{
    private readonly Generator $faker;

    protected function setUp(): void
    {
        $this->faker = Factory::create();
    }

    public function testItThrowsJsonExceptionIfTheProvidedEncodedStringIsNotValidJson(): void
    {
        $invalidJson = '{';

        $this->expectException(JsonException::class);

        JsonFeed::fromJson($invalidJson);
    }

    public static function provideInvalidRawFeedDataAndExpectedException(): array
    {
        $faker = Factory::create();

        return [
            'raw feed data misses products' => [
                [
                    [],
                ],
                new InvalidArgumentException(sprintf(
                    'Invalid %s, %s key needed',
                    JsonFeed::class,
                    'products',
                )),
            ],
            'product misses title' => [
                [
                    'products' => [
                        [],
                    ],
                ],
                new InvalidArgumentException(sprintf(
                    'Invalid %s, %s key needed',
                    Product::class,
                    'title',
                )),
            ],
            'product misses product type' => [
                [
                    'products' => [
                        [
                            'title' => $faker->word(),
                        ],
                    ],
                ],
                new InvalidArgumentException(sprintf(
                    'Invalid %s, %s key needed',
                    Product::class,
                    'product_type',
                )),
            ],
            'product misses variants' => [
                [
                    'products' => [
                        [
                            'title' => $faker->word(),
                            'product_type' => $faker->randomElement(
                                array_map(
                                    fn(Type $type): string => $type->value,
                                    Type::cases(),
                                )
                            ),
                        ],
                    ],
                ],
                new InvalidArgumentException(sprintf(
                    'Invalid %s, %s key needed',
                    Product::class,
                    'variants',
                )),
            ],
            'product variant misses the title' => [
                [
                    'products' => [
                        [
                            'title' => $faker->word(),
                            'product_type' => $faker->randomElement(
                                array_map(
                                    fn(Type $type): string => $type->value,
                                    Type::cases(),
                                )
                            ),
                            'variants' => [
                                [],
                            ],
                        ],
                    ],
                ],
                new InvalidArgumentException(sprintf(
                    'Invalid %s, %s key needed',
                    Variant::class,
                    'title',
                )),
            ],
            'product variant misses the price' => [
                [
                    'products' => [
                        [
                            'title' => $faker->word(),
                            'product_type' => $faker->randomElement(
                                array_map(
                                    fn(Type $type): string => $type->value,
                                    Type::cases(),
                                )
                            ),
                            'variants' => [
                                [
                                    'title' => $faker->word(),
                                ],
                            ],
                        ],
                    ],
                ],
                new InvalidArgumentException(sprintf(
                    'Invalid %s, %s key needed',
                    Variant::class,
                    'price',
                )),
            ],
        ];
    }

    #[DataProvider('provideInvalidRawFeedDataAndExpectedException')]
    public function testItThrowsInvalidArgumentExceptionIfTheRawFeedDataIsNotValid(
        array $rawFeedData,
        InvalidArgumentException $expectedException,
    ): void {
        $this->expectExceptionObject($expectedException);

        JsonFeed::fromJson(json_encode($rawFeedData));
    }

    public function testItProperlyDecodesAJsonEncodedString(): void
    {
        $data = [
            'products' => [
                [
                    'title' => $productTitle = $this->faker->word(),
                    'product_type' => $productTypeString = $this->faker->randomElement(
                        array_map(
                            fn(Type $type): string => $type->value,
                            Type::cases(),
                        )
                    ),
                    'variants' => [
                        [
                            'title' => $variantTitle = $this->faker->word(),
                            'price' => $priceType = $this->faker->randomFloat(2, 10),
                        ],
                    ],
                ],
            ],
        ];

        $expectedFeed = [
            new Product(
                $productTitle,
                Type::from($productTypeString),
                new Variant(
                    $variantTitle,
                    $priceType,
                ),
            ),
        ];

        $feed = JsonFeed::fromJson(json_encode($data));

        $this->assertEquals($expectedFeed, $feed->toArray());
    }
}