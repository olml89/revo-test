<?php

declare(strict_types=1);

namespace Tests\PrimeNumbers;

use Faker\Factory;
use InvalidArgumentException;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;
use RevoTest\PrimeNumbers\NumberInputReader;

#[CoversClass(NumberInputReader::class)]
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
        ];
    }

    #[DataProvider('provideInvalidInputs')]
    public function testItThrowsInvalidArgumentExceptionForInvalidInputs(mixed $invalidInput): void
    {
        $readlineArgument = (string)$invalidInput;

        $this->expectExceptionObject(
            new InvalidArgumentException('Input must be an integer.')
        );

        NumberInputReader::fromConsole($readlineArgument);
    }

    public function testItAllowsIntegersAsInput(): void
    {
        $int = Factory::create()->numberBetween();
        $readlineArgument = (string)$int;

        $this->assertEquals($int, NumberInputReader::fromConsole($readlineArgument)->number);
    }
}