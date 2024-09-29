<?php

declare(strict_types=1);

namespace RevoTest\Movies\Statement;

use RevoTest\Movies\Rental;

interface StatementGenerator
{
    public function generate(string $customerName, Rental ...$customerRentals): string;
}