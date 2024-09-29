<?php

declare(strict_types=1);

namespace RevoTest\PrimeNumbers;

interface PrimeNumbersCalculator
{
    /**
     * It returns all the prime numbers between 0 and a given input (including it).
     *
     * @return int[]
     */
    public function calculate(int $number): array;
}