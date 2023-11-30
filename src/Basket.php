<?php

namespace Gloversure\Store;

/**
 * Holds information about the users' current basket
 * Calculates the total for the basket
 * 
 * @package \Gloversure\Store
 */
class Basket
{
    /**
     * @var float                 $total    total price of the basket
     * @var Array<Basket\Product> $products all products currently in the basket
     */
    public float $total = 0;
    private Array $products = [];

    /**
     * Adds a product to the basket
     * Should update the 
     *
     * @param \Gloversure\Store\Product $product  product to add to the basket
     * @param int                       $quantity number of products to add to the basket
     * 
     * @return void
     */
    public function addItems(Product $product, int $quantity = 0): void
    {
        if (isset($this->products[$product->sku]))
            $this->products[$product->sku]->quantity += $quantity;
        else {
            $newProduct = new Basket\Product(
                $product,
                $quantity,
            );

            $this->products[$product->sku] = $newProduct;
        }       
        $this->calculateTotal();
    }

    /**
     * Calculates the total for the basket
     * 
     * @return void
     */
    protected function calculateTotal(): void
    {
        $this->total = 0;
        
        // filter out both apples and oranges from basket
        $applesOranges = array_filter($this->products, function($product) {
            return $product->product->sku == "OR01" || $product->product->sku == "AP01";
        });
        // apply apples and oranges discount if both exist in basket
        if (count($applesOranges) === 2) {
           $this->total += $this->discountTotal($applesOranges); 
        }

        /** @var Basket\Product $product */
        foreach ($this->products as $product) {
            $this->total += match ($product->product->sku) {
                'CH01' => $this->halfPriceTotal($product),
                'ST01' => $this->strawberriesTotal($product),
                'OR01' => match (count($applesOranges) === 2) {
                    true => 0,
                    false => $product->product->price * $product->quantity,
                },
                'AP01' => match (count($applesOranges) === 2) {
                    true => 0,
                    false => $product->product->price * $product->quantity,
                },
                default => $product->product->price * $product->quantity,
            };
        }
        
    }

    /** 
    * Calculate the total price of items when buy one get one free    
    * 
    * @return float
    * */
    protected function halfPriceTotal(Basket\Product $product): float
    {
        // half the even number of products
        $quantity = floor($product->quantity / 2);

        // calculate the odd remainder number of the products
        $oddItem = $product->quantity % 2;

        // half-price for even numbers plus an additional odd item at full-price
        $totalPrice = ($product->product->price * $quantity) + ($oddItem * $product->product->price);
       
        return $totalPrice;
    }

    /** 
    * Calculate the total price of strawberries with bulk buy offer    
    * 
    * @return float
    * */
    protected function strawberriesTotal(Basket\Product $strawberry): float
    {
        $totalPrice = 0;
        
        if ($strawberry->quantity >= 4) {
            $totalPrice = 3.99 * $strawberry->quantity;
        } else {
            $totalPrice = $strawberry->product->price * $strawberry->quantity;
        }
        
        return $totalPrice;
    }

    /** 
    * Calculate the total price of two types of products
    * with buy one get one free offer where the cheaper product is free
    * 
    * @return float
    * */
    protected function discountTotal(Array $products): float
    {
        $totalPrice = 0;
        
        // get each of the two products
        $product1 = array_values($products)[0];
        $product2 = array_values($products)[1];

        // substract the cheaper free product
        if ($product1->product->price > $product2->product->price) {
            $halfPriceTotal = $this->halfPriceTotal($product2);
            $totalPrice = ($product1->quantity * $product1->product->price) + $halfPriceTotal;
            // $totalPrice -= $freeProduct2 * $product2->product->price;
        } else if ($product2->product->price > $product1->product->price) {
            $halfPriceTotal = $this->halfPriceTotal($product1);
            $totalPrice = ($product2->quantity * $product2->product->price) + $halfPriceTotal;
            // $totalPrice -= $freeProduct1 * $product1->product->price;
        }

        return $totalPrice;
    }

}
