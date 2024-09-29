<?php

declare(strict_types=1);

namespace RevoTest\PrimeNumbers;

final class EratosthenesPrimeNumbersCalculator implements PrimeNumbersCalculator
{
    public function calculate(int $number): array
    {
        $limit = (int)sqrt($number);

        $primeNumbersHash = [
            0 => false,
            1 => false,
            ...array_fill(2, max($number - 1, 0), true),
        ];

        for ($i = 2; $i <= $limit; $i++) {
            if ($primeNumbersHash[$i]) {
                for ($j = $i * $i; $j <= $number; $j += $i) {
                    $primeNumbersHash[$j] = false;
                }
            }
        }

        return array_keys(array_filter($primeNumbersHash));
    }
}