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
            $rentalAmount = 0;

            switch ($rental->getMovie()->getPriceCode()) {
                case Movie::REGULAR:
                    $rentalAmount += 2;
                    if ($rental->getDaysRented() > 2) {
                        $rentalAmount += ($rental->getDaysRented() - 2) * 1.5;
                    }
                    break;
                case Movie::NEW_RELEASE:
                    $rentalAmount += $rental->getDaysRented() * 3;
                    break;
                case Movie::CHILDRENS:
                    $rentalAmount += 1.5;
                    if ($rental->getDaysRented() > 3) {
                        $rentalAmount += ($rental->getDaysRented() - 3) * 1.5;
                    }
                    break;
            }

            // Add frequent render points
            ++$frequentRenterPoints;

            if ($rental->getMovie()->getPriceCode() === Movie::NEW_RELEASE && $rental->getDaysRented() > 1) {
                ++$frequentRenterPoints;
            }

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