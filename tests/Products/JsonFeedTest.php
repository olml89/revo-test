<?php

declare(strict_types=1);

namespace Tests\Products;

use Faker\Factory;
use Faker\Generator;
use InvalidArgumentException;
use JsonException;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\TestCase;
use RevoTest\Products\Feeds\JsonFeed;
use RevoTest\Products\Product;
use RevoTest\Products\Type;
use RevoTest\Products\Variant;

#[CoversClass(JsonFeed::class)]
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

    public function testItThrowsInvalidArgumentExceptionIfAProductFeedMissesProducts(): void
    {
        $data = [
            [],
        ];

        $this->expectExceptionObject(
            new InvalidArgumentException(sprintf(
                'Invalid %s, %s key needed',
                JsonFeed::class,
                'products',
            )),
        );

        JsonFeed::fromJson(json_encode($data));
    }

    public function testItThrowsInvalidArgumentExceptionIfAProductMissesTheTitle(): void
    {
        $data = [
            'products' => [
                [],
            ],
        ];

        $this->expectExceptionObject(
            new InvalidArgumentException(sprintf(
                'Invalid %s, %s key needed',
                Product::class,
                'title',
            )),
        );

        JsonFeed::fromJson(json_encode($data));
    }

    public function testItThrowsInvalidArgumentExceptionIfAProductMissesTheProductType(): void
    {
        $data = [
            'products' => [
                [
                    'title' => $this->faker->word(),
                ],
            ],
        ];

        $this->expectExceptionObject(
            new InvalidArgumentException(sprintf(
                'Invalid %s, %s key needed',
                Product::class,
                'product_type',
            )),
        );

        JsonFeed::fromJson(json_encode($data));
    }

    public function testItThrowsInvalidArgumentExceptionIfAProductMissesTheVariant(): void
    {
        $data = [
            'products' => [
                [
                    'title' => $this->faker->word(),
                    'product_type' => $this->faker->randomElement(
                        array_map(
                            fn(Type $type): string => $type->value,
                            Type::cases(),
                        )
                    ),
                ],
            ],
        ];

        $this->expectExceptionObject(
            new InvalidArgumentException(sprintf(
                'Invalid %s, %s key needed',
                Product::class,
                'variants',
            )),
        );

        JsonFeed::fromJson(json_encode($data));
    }

    public function testItThrowsInvalidArgumentExceptionIfAProductVariantMissesTheTitle(): void
    {
        $data = [
            'products' => [
                [
                    'title' => $this->faker->word(),
                    'product_type' => $this->faker->randomElement(
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
        ];

        $this->expectExceptionObject(
            new InvalidArgumentException(sprintf(
                'Invalid %s, %s key needed',
                Variant::class,
                'title',
            )),
        );

        JsonFeed::fromJson(json_encode($data));
    }

    public function testItThrowsInvalidArgumentExceptionIfAProductVariantMissesThePrice(): void
    {
        $data = [
            'products' => [
                [
                    'title' => $this->faker->word(),
                    'product_type' => $this->faker->randomElement(
                        array_map(
                            fn(Type $type): string => $type->value,
                            Type::cases(),
                        )
                    ),
                    'variants' => [
                        [
                            'title' => $this->faker->word(),
                        ],
                    ],
                ],
            ],
        ];

        $this->expectExceptionObject(
            new InvalidArgumentException(sprintf(
                'Invalid %s, %s key needed',
                Variant::class,
                'price',
            )),
        );

        JsonFeed::fromJson(json_encode($data));
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