<?php

declare(strict_types=1);

use RevoTest\PrimeNumbers\EratosthenesPrimeNumbersCalculator;
use RevoTest\PrimeNumbers\NaturalNumber;

require __DIR__ . '/../vendor/autoload.php';

$naturalNumber = NaturalNumber::fromConsole(readline('Input a number: '));
$primeNumbers = (new EratosthenesPrimeNumbersCalculator())->calculate($naturalNumber);

if (count($primeNumbers) === 0) {
    echo sprintf('There are no prime numbers until %s.', $naturalNumber) . PHP_EOL;
    exit;
}

echo sprintf('Prime numbers until %s: ', $naturalNumber) . implode(', ', $primeNumbers) . PHP_EOL;