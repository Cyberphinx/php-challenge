<?php

namespace Gloversure\Store;

class Product
{
    public readonly string $sku;
    public readonly string $name;
    public readonly float $price;
    public readonly int $amountInStock;

    /**
     * @throws Exception\BadProductException
     */
    public function __construct(string $sku, string $name, float $price, int $amountInStock)
    {
        if (!$sku || !$name || !$price)
            throw new Exception\BadProductException("Product does not contain all required information");

        $this->sku = $sku;
        $this->name = $name;
        $this->price = $price;
        $this->amountInStock = $amountInStock;
    }
}