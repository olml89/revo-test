<?php

declare(strict_types=1);

use RevoTest\PrimeNumbers\NumberInputReader;

$input = NumberInputReader::fromConsole(readline('Input a number: '));