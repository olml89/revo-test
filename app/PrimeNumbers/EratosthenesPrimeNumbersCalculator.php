<?php

declare(strict_types=1);

namespace RevoTest\PrimeNumbers;

final class EratosthenesPrimeNumbersCalculator implements PrimeNumbersCalculator
{
    public function calculate(NaturalNumber $number): array
    {
        $limit = sqrt($number->value);
        $start = 2;

        $primeNumbersHashTable = array_fill(start_index: $start, count: $number->value - 1, value: true);

        for ($i = $start; $i <= $limit; $i++) {
            if ($primeNumbersHashTable[$i]) {
                for ($j = $i * $i; $j <= $number->value; $j += $i) {
                    $primeNumbersHashTable[$j] = false;
                }
            }
        }

        return array_keys(array_filter($primeNumbersHashTable));
    }
}