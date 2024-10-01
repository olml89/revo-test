<?php

declare(strict_types=1);

namespace RevoTest\Movies;

use RevoTest\Movies\Statement\StatementGenerator;

final class Customer
{
    /**
     * @var Rental[]
     */
    private array $rentals;

    public function __construct(
        public readonly string $name,
    ) {
    }

    public function addRental(Rental $rental): self
    {
        $this->rentals[] = $rental;

        return $this;
    }

    public function statement(StatementGenerator $statementPrinter): string
    {
        return $statementPrinter->generate($this->name, ...$this->rentals);
    }
}