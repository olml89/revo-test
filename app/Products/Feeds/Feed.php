<?php

declare(strict_types=1);

namespace RevoTest\Products\Feeds;

use RevoTest\Products\Product;

interface Feed
{
    /**
     * @return Product[]
     */
    public function toArray(): array;
}