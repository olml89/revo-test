<?php

declare(strict_types=1);

namespace RevoTest\Movies\Statement;

use RevoTest\Movies\Rental;

final class ConsoleStatementGenerator implements StatementGenerator
{
    public function generate(string $customerName, Rental ...$customerRentals): string
    {
        $totalAmount = 0;
        $frequentRenterPoints = 0;
        $result = sprintf('Rental Record for %s%s', $customerName, PHP_EOL);

        foreach ($customerRentals as $rental) {
            $rentalAmount = $rental->movie->getAmount($rental->daysRented);

            // Add frequent render points
            $frequentRenterPoints += $rental->movie->getFrequentRenderPoints($rental->daysRented);

            // Show figures for each rental
            $result .= "\t" . $rental->movie->getTitle() . "\t" . $rentalAmount . PHP_EOL;
            $totalAmount += $rentalAmount;
        }

        // Add footer lines
        $result .= sprintf('Amount owed is %s%s', $totalAmount, PHP_EOL);
        $result .= sprintf('You earned %s frequent renter points%s', $frequentRenterPoints, PHP_EOL);

        return $result;
    }
}