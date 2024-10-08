<p align="center"><a href="https://revo.works/ca" target="_blank"><img src="https://community.revo.works/web/image/68993-18d0811f/Revo_logo_naranja.png" width="400" alt="Revo"></a></p>

<p align="center">
<a href="https://opensource.org/licenses/MIT"><img src="https://img.shields.io/badge/License-MIT-green.svg" alt="License"></a>
<a href="https://github.com/olml89/revo-test"><img src="https://github.com/olml89/revo-test/actions/workflows/tests.yml/badge.svg" alt="Tests"></a>
<a href="https://codecov.io/gh/olml89/revo-test"><img src="https://codecov.io/gh/olml89/revo-test/branch/main/graph/badge.svg?token=SL6ANXRH0A" alt="Coverage status"></a>
</p>

# Description

This is an implementation of a technical test for a senior developer role at
**[revo](https://revo.works/ca)**
following
[this specifications](https://support.revo.works/en/articles/205?preview=1)

# Installation

Create a **.env** file from the **.env.example** skeleton

````php
cp .env.example .env
````

Build and spin up the docker containers

````php
make upd
````

Log into the php container ssh shell

````php
make ssh
````

There you can execute the application entry points located at **/bin** or run tests:

````php
./vendor/bin/phpunit tests
````
# Exercises

## Collections

A working demonstration has been implemented and can be executed:

````php
php ./bin/github-score.php
````

The prompt will ask for a valid github account handle. When it is input, it will calculate its current GitHub score
with the requirements given by the exercise description. Be aware that there's a rate limit when hitting the GitHub API
so it can only be reached a limited amount of times for a given period.

The implementation works using ```file_get_contents()``` to get the raw GitHub events data as suggested by the exercise.

An error will be output if there's a problem reaching the GitHub API or decoding the raw data.

## Collections 2

This exercise has been solved using a ```Type``` enum implementing the different categories of products and a
```FeedTotalPriceCalculator``` that can take a variable amount of types to filter the types of products that should
be taken into account when calculating the feed total price. So, to get the results required in the exercise statement, we
would have to do:

````php
use RevoTest\Products\FeedTotalPriceCalculator;
use RevoTest\Products\Type;

$calculator = new FeedTotalPriceCalculator();

$calculator->calculate($feed, Type::Wallet, Type::Lamp)

$calculator->calculate($feed, ...[
    Type::Wallet,
    Type::Lamp,
]);
````

The feed will raise an error if the json is not in the expected format given by the exercise example.

To add support for products different than wallets, shoes or lamps, they would have to be added in the ```Type``` enum.

## Refactor

This exercise has been solved using a ```Movie``` interface and then implementing it through different implementations, 
each of which is responsible of the calculation of its amount and frequent renter points using the specifications given
in the exercise statement.

To add support for the 3 new types of movies, a new ```Movie``` implementation would need to be added for each one.

To add support for the 2 new types of outputs, a new ```StatementGenerator``` implementation would need to be added for each one.

There's a ```foreach``` loop kept in this exercise as it was already present in the original exercise statement.

## Testing

A working demonstration has been implemented and can be executed:

````php
php ./bin/prime-numbers.php
````
The prompt will ask for a natural number. When it is input, it will calculate all the prime numbers
up to and including that number using the Eratosthenes sieve algorithm. It has been optimized to save up memory usage.

An error would be output if the input is not a valid positive integer.


