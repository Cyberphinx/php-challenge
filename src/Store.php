<?php

namespace Gloversure\Store;

final class Store
{
    /**
     * @var array<Product> $products
     */
    private $products = [];

    private $storeXmlPath = '';
    private $storeContext = null;

    public function __construct(string $storeXml)
    {
        if (!file_exists($storeXml))
            throw new Exception\FileNotFoundException("Store XML \"{$storeXml}\" doesn't exist");

        $contents = file_get_contents($storeXml);
        $xml = new \SimpleXMLElement($contents);

        $this->products = $this->parseXml($xml);

        $this->storeXmlPath = $storeXml;
        $this->storeContext = $xml;
    }

    /**
     * Get a product from the store
     * 
     * @param string $sku
     * 
     * @return Product
     * @throws Exception\ProductNotFoundException
     */
    public function addProduct(string $sku, string $name, int $quantity, float $price ): string
    {
        if (!isset($this->products[$sku])) {
            // if product sku doesn't exist, we add new product
            $newProduct = $this->storeContext->products->addChild('product');
            $newProduct->addAttribute('sku', $sku);
            $newProduct->addAttribute('name', $name);
            $newProduct->addAttribute('price', $price);

            // add new inventory
            $newInventory = $this->storeContext->inventory->addChild('product');
            $newInventory->addAttribute('sku', $sku);
            $newInventory->addAttribute('amount', $quantity);

            // formatted save
            $updatedXml = $this->storeContext->asXML();
            $dom = new \DOMDocument();
            $dom->preserveWhiteSpace = false;
            $dom->formatOutput = true;
            $dom->loadXML($updatedXml);
            $dom->save($this->storeXmlPath); 

            // add the new product to the array
            $this->products[$sku] = new Product (
                $sku, $name, $price, $quantity
            );

            // provide a message confirm its added successfully
            $message = "\n" . $this->products[$sku]->name . " added successfully";
            return $message;
        } else {
            // if product sku already exist, provide a message without throwing error
            $message = "\nProduct " . $name . " already exist";
            return $message;
        }
    }

    /**
     * Get a product from the store
     * 
     * @param string $sku
     * 
     * @return Product
     * @throws Exception\ProductNotFoundException
     */
    public function getProduct(string $sku): Product
    {
        if (!isset($this->products[$sku]))
            throw new Exception\ProductNotFoundException("Product with sku \"{$sku}\" doesn't exist");

        return $this->products[$sku];
    }

    /**
     * Turns the store XML into an array of products
     * 
     * @param \SimpleXmlElement $xml
     * 
     * @return array<Product>
     */
    private function parseXml(\SimpleXMLElement $xml): array
    {
        /**
         * @var array<Product> $products
         * @var array<int> $inventory associated array of sku to amount in stock
         */
        $products = [];
        $inventory = $this->getProductInventory($xml);

        $index = 0;
        foreach ($xml->products->product as $product) {
            $attrs = $product->attributes();

            $sku = (string) $attrs['sku'];
            $name = (string) $attrs['name'];
            $price = (float) $attrs['price'];

            try {
                $products[$sku] = new Product(
                    $sku,
                    $name,
                    $price,
                    $inventory[$sku] ?? 0
                );
            } catch (Exception\BadProductException $e) {
                throw new Exception\BadProductException(
                    "Product with index {$index} does not contain all required information"
                );
            }

            $index += 1;
        }
        return $products;
    }

    /**
     * arse the inventory XML and store this against the product
     * 
     * @param \SimpleXmlElement $xml
     * 
     * @return array<Inventory>
     */
    private function getProductInventory($xml): array
    {
        /**
         * @var array<int> $inventory associated array of sku to amount in stock
         */
        $inventory = [];
        $index = 0;
        foreach ($xml->inventory->product as $item) {
            $attrs = $item->attributes();
            $sku = (string) $attrs['sku'];
            $amount = (int) $attrs['amount'];

            try {
                $inventory[$sku] = $amount;
            } catch (Exception\BadInventoryLineException $e) {
                throw new Exception\BadInventoryLineException(
                    "Inventory with index {$index} does not contain all required information"
                );
            }

            $index += 1;
        }

        return $inventory;
    }
}
