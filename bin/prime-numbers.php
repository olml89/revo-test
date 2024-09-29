<?php

declare(strict_types=1);

use RevoTest\PrimeNumbers\EratosthenesPrimeNumbersCalculator;
use RevoTest\PrimeNumbers\NumberInputReader;

require __DIR__ . '/../vendor/autoload.php';

$input = NumberInputReader::fromConsole(readline('Input a number: '));
$primeNumbers = (new EratosthenesPrimeNumbersCalculator())->calculate($input->number);

if (count($primeNumbers) === 0) {
    echo sprintf('There are no prime numbers until %s.', $input->number) . PHP_EOL;
    exit;
}

echo sprintf('Prime numbers until %s: ', $input->number) .implode(', ', $primeNumbers) . PHP_EOL;