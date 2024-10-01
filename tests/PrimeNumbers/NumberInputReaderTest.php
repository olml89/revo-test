<?php

declare(strict_types=1);

namespace Tests\PrimeNumbers;

use Faker\Factory;
use InvalidArgumentException;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;
use RevoTest\PrimeNumbers\NaturalNumber;

#[CoversClass(NaturalNumber::class)]
final class NumberInputReaderTest extends TestCase
{
    public static function provideInvalidInputs(): array
    {
        $faker = Factory::create();

        return [
            'random string' => [
                $faker->word(),
            ],
            'float' => [
                (function () use ($faker): float {
                    do {
                        $float = $faker->randomFloat();
                    } while ((int)$float == $float);

                    return $float;
                })(),
            ],
            'negative number' => [
                $faker->numberBetween(-1000, -1),
            ],
            'zero' => [
                0,
            ],
        ];
    }

    #[DataProvider('provideInvalidInputs')]
    public function testItThrowsInvalidArgumentExceptionForInvalidInputs(mixed $invalidInput): void
    {
        $readlineArgument = (string)$invalidInput;

        $this->expectExceptionObject(
            new InvalidArgumentException('Input must be a natural number.')
        );

        NaturalNumber::fromConsole($readlineArgument);
    }

    public function testItAllowsNaturalNumbersAsInput(): void
    {
        $naturalNumber = Factory::create()->numberBetween();
        $readlineArgument = (string)$naturalNumber;

        $this->assertEquals($naturalNumber, NaturalNumber::fromConsole($readlineArgument)->value);
    }
}