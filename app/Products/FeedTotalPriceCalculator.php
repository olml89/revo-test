<?php

declare(strict_types=1);

namespace RevoTest\Products;

use RevoTest\Products\Feeds\Feed;

final class FeedTotalPriceCalculator
{
    public function calculate(Feed $feed, Type ...$allowedTypes): float
    {
        return array_reduce(
            array: $feed->toArray(),
            callback: fn(float $carry, Product $product): float => $carry + $product->getTotalPrice(...$allowedTypes),
            initial: 0.0
        );
    }
}