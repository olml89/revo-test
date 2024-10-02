<?php

declare(strict_types=1);

namespace RevoTest\PrimeNumbers;

interface PrimeNumbersCalculator
{
    /**
     * It returns all the prime numbers until a given natural number (including it).
     *
     * @return int[]
     */
    public function calculate(NaturalNumber $number): array;
}