<?php

declare(strict_types=1);

namespace Tests\PrimeNumbers;

use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;
use RevoTest\PrimeNumbers\EratosthenesPrimeNumbersCalculator;
use RevoTest\PrimeNumbers\NaturalNumber;

#[CoversClass(EratosthenesPrimeNumbersCalculator::class)]
final class EratosthenesPrimeNumbersCalculatorTest extends TestCase
{
    private readonly EratosthenesPrimeNumbersCalculator $calculator;

    protected function setUp(): void
    {
        $this->calculator = new EratosthenesPrimeNumbersCalculator();
    }

    public static function provideNumberAndExpectedResults(): array
    {
        return [
            [
                NaturalNumber::fromInt(1),
                [],
            ],
            [
                NaturalNumber::fromInt(2),
                [2],
            ],
            [
                NaturalNumber::fromInt(3),
                [2, 3],
            ],
            [
                NaturalNumber::fromInt(100),
                [2, 3, 5, 7, 11, 13, 17, 19, 23, 29, 31, 37, 41, 43, 47, 53, 59, 61, 67, 71, 73, 79, 83, 89, 97],
            ],
        ];
    }

    #[DataProvider('provideNumberAndExpectedResults')]
    public function testItReturnsExpectedResults(NaturalNumber $number, array $expectedResults): void
    {
        $this->assertEquals($expectedResults, $this->calculator->calculate($number));
    }
}