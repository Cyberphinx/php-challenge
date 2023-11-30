<?php

namespace Gloversure\Store\Basket;

use Gloversure\Store\Product as BaseProduct;

/**
 * A product with a quantity
 */
class Product
{
    public function __construct(public readonly BaseProduct $product, public int $quantity)
    {
    }
}