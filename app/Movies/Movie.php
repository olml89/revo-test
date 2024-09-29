<?php

declare(strict_types=1);

namespace RevoTest\Movies;

final class Movie
{
    public const int CHILDRENS = 2;
    public const int NEW_RELEASE = 1;
    public const int REGULAR = 0;

    public function __construct(
        private readonly string $title,
        private int $priceCode,
    ) {}

    public function getTitle(): string
    {
        return $this->title;
    }

    public function getPriceCode(): int
    {
        return $this->priceCode;
    }

    public function setPriceCode(int $priceCode): self
    {
        $this->priceCode = $priceCode;

        return $this;
    }
}