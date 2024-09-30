<?php

declare(strict_types=1);

namespace RevoTest\Products;

use InvalidArgumentException;

trait ValidatesKeys
{
    /**
     * @throws InvalidArgumentException
     */
    private static function getData(string $key, array $data): mixed
    {
        return $data[$key] ?? throw new InvalidArgumentException(sprintf(
            'Invalid %s, %s key needed',
            self::class,
            $key,
        ));
    }
}