<?php

declare(strict_types=1);

namespace Tests\Movies;

use Faker\Factory;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;
use RevoTest\Movies\Customer;
use RevoTest\Movies\Movie\Movie;
use RevoTest\Movies\Rental;
use RevoTest\Movies\Statement\ConsoleStatementGenerator;
use RevoTest\Movies\Statement\StatementGenerator;

#[CoversClass(Customer::class)]
final class CustomerTest extends TestCase
{
    public static function provideCustomerAndExpectedStatement(): array
    {
        $faker = Factory::create();
        $regularMovieCreator = new RegularMovieCreator($faker);
        $childrenMovieCreator = new ChildrenMovieCreator($faker);
        $newReleaseMovieCreator = new NewReleaseMovieCreator($faker);

        return [
            [
                $customer = (new Customer($faker->name()))->addRental(
                    new Rental(($movie = $regularMovieCreator->create()), daysRented: 2)
                ),
                new ConsoleStatementGenerator(),
                self::generateExpectedStatement($customer, $movie, expectedMovieAmount: 2, expectedTotalAmount: 2, frequentRenterPoints: 1),
            ],
            [
                $customer = (new Customer($faker->name()))->addRental(
                    new Rental(($movie = $regularMovieCreator->create()), daysRented: 3)
                ),
                new ConsoleStatementGenerator(),
                self::generateExpectedStatement($customer, $movie, expectedMovieAmount: 3.5, expectedTotalAmount: 3.5, frequentRenterPoints: 1),
            ],
            [
                $customer = (new Customer($faker->name()))->addRental(
                    new Rental(($movie = $newReleaseMovieCreator->create()), daysRented: 1)
                ),
                new ConsoleStatementGenerator(),
                self::generateExpectedStatement($customer, $movie, expectedMovieAmount: 3, expectedTotalAmount: 3, frequentRenterPoints: 1),
            ],
            [
                $customer = (new Customer($faker->name()))->addRental(
                    new Rental(($movie = $newReleaseMovieCreator->create()), daysRented: 2)
                ),
                new ConsoleStatementGenerator(),
                self::generateExpectedStatement($customer, $movie, expectedMovieAmount: 6, expectedTotalAmount: 6, frequentRenterPoints: 2),
            ],
            [
                $customer = (new Customer($faker->name()))->addRental(
                    new Rental(($movie = $childrenMovieCreator->create()), daysRented: 3)
                ),
                new ConsoleStatementGenerator(),
                self::generateExpectedStatement($customer, $movie, expectedMovieAmount: 1.5, expectedTotalAmount: 1.5, frequentRenterPoints: 1),
            ],
            [
                $customer = (new Customer($faker->name()))->addRental(
                    new Rental(($movie = $childrenMovieCreator->create()), daysRented: 4)
                ),
                new ConsoleStatementGenerator(),
                self::generateExpectedStatement($customer, $movie, expectedMovieAmount: 3, expectedTotalAmount: 3, frequentRenterPoints: 1),
            ],
        ];
    }

    private static function generateExpectedStatement(
        Customer $customer,
        Movie $movie,
        float $expectedMovieAmount,
        float $expectedTotalAmount,
        int $frequentRenterPoints,
    ): string {
        return sprintf(
            'Rental Record for %s%s%s%s%s%s%sAmount owed is %s%sYou earned %s frequent renter points%s',
            $customer->getName(),
            PHP_EOL,
            "\t",
            $movie->getTitle(),
            "\t",
            $expectedMovieAmount,
            PHP_EOL,
            $expectedTotalAmount,
            PHP_EOL,
            $frequentRenterPoints,
            PHP_EOL
        );
    }

    #[DataProvider('provideCustomerAndExpectedStatement')]
    public function testItReturnsCorrectStatement(Customer $customer, StatementGenerator $statementGenerator, string $expectedStatement): void
    {
        $this->assertEquals($expectedStatement, $customer->statement($statementGenerator));
    }
}