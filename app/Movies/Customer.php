<?php

declare(strict_types=1);

namespace RevoTest\Movies;

final class Customer
{
    /**
     * @var Rental[]
     */
    private array $rentals;

    public function __construct(
        private readonly string $name,
        Rental ...$rentals
    ) {
        $this->rentals = $rentals;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function addRental(Rental $rental): self
    {
        $this->rentals[] = $rental;

        return $this;
    }

    public function statement(): string
    {
        $totalAmount = 0;
        $frequentRenterPoints = 0;
        $result = sprintf('Rental Record for %s%s', $this->name, PHP_EOL);

        foreach ($this->rentals as $rental) {
            $rentalAmount = $rental->getMovie()->getAmount($rental->getDaysRented());

            // Add frequent render points
            $frequentRenterPoints += 1 + $rental->getMovie()->getFrequentRenderPoints($rental->getDaysRented());

            // Show figures for each rental
            $result .= "\t" . $rental->getMovie()->getTitle() . "\t" . $rentalAmount . PHP_EOL;
            $totalAmount += $rentalAmount;
        }

        // Add footer lines
        $result .= sprintf('Amount owed is %s%s', $totalAmount, PHP_EOL);
        $result .= sprintf('You earned %s frequent renter points%s', $frequentRenterPoints, PHP_EOL);

        return $result;
    }
}