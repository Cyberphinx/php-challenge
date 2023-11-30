<?php

$autoloadPath = implode(DIRECTORY_SEPARATOR, [
    __DIR__,
    'vendor',
    'autoload.php',
]);

if (!file_exists($autoloadPath)) {
    print_r('Run `composer dump-autoload` and try again');
    exit();
}

require_once($autoloadPath);

$path = [
    __DIR__,
    'xml',
    'store.xml',
];
$store = new \Gloversure\Store\Store(implode(DIRECTORY_SEPARATOR, $path));

/**
 * example 1: 
 * add 6 Strawberries to basket and calculate total price
 *
 * total price without discounts: 35.94
 * total price with bulk buy discounts: 23.94
 */
function example1() {
    global $store;

    $basket = new \Gloversure\Store\Basket();

    $basket->addItems(
        $store->getProduct('ST01'),
        6
    );

    return $basket->total;
}

/**
 * example 2: 
 * add 2 Chocolate Bars to basket and calculate total price
 *
 * total price without discounts: 5.98
 * total price with buy one get one free for chocolate: 2.99
 */
function example2() {
    global $store;

    $basket = new \Gloversure\Store\Basket();

    $basket->addItems(
        $store->getProduct('CH01'),
        2
    );

    return $basket->total;
}

/**
 * example 3: 
 * add 4 Chocolate Bars to basket and calculate total price
 *
 * total price without discounts: 11.96
 * total price with buy one get one free for chocolate: 5.98
 */
function example3() {
    global $store;

    $basket = new \Gloversure\Store\Basket();

    $basket->addItems(
        $store->getProduct('CH01'),
        4
    );

    return $basket->total;
}

/**
 * example 4: 
 * add 4 Strawberries and 4 Chocolate Bars  and calculate total price
 *
 * total price without discounts: 35.92 (Strawberries 23.96 plus Chocolate 11.96)
 * total price with buy one get one free for choclate: 29.94 (Strawberries 23.96 plus Chocolate: 5.98)
 */
function example4() {
    global $store;

    $basket = new \Gloversure\Store\Basket();

    $basket->addItems(
        $store->getProduct('ST01'),
        4
    );
    $basket->addItems(
        $store->getProduct('CH01'),
        4
    );

    return $basket->total;
}


/**
 * Challenge 3: 
 *
 * add new products and save them in the store.xml file
 */
function challenge3() {
    global $store;

    $addedOranges = $store->addProduct('OR01', 'Oranges', 20, 0.4);
    $addedBacons =  $store->addProduct('BA01', 'Bacon', 5, 1.99);

    return $addedOranges . " " . $addedBacons;
}

/**
 * example 5: 
 * add 3 Oranges and 4 Bacons to basket and calculate total price
 *
 * total price: 5.18 (Oranges 1.2 plus Bacons 3.98)
 */
function example5() {
    global $store;

    $basket = new \Gloversure\Store\Basket();

    $basket->addItems(
        $store->getProduct('OR01'),
        3
    );
    $basket->addItems(
        $store->getProduct('BA01'),
        2
    );

    return $basket->total;
}

/**
 * Challenge 4 test: 
 * add 6 Oranges and 4 Apples to basket and calculate total price
 *
 * total price without discount: 4.4 (Oranges 2.4 plus Apples 2)
 * total price with buy one get one free (cheapest item free): 3.2 (Oranges 1.2 plus Apples 2)
 */
function challenge4() {
    global $store;

    $basket = new \Gloversure\Store\Basket();

    $basket->addItems(
        $store->getProduct('OR01'),
        6
    );
    $basket->addItems(
        $store->getProduct('AP01'),
        4
    );

    return $basket->total;
}

// print_r('Example 1 result: ' . example1() . PHP_EOL);
// print_r('Example 2 result: ' . example2() . PHP_EOL);
// print_r('Example 3 result: ' . example3() . PHP_EOL);
// print_r('Example 4 result: ' . example4() . PHP_EOL);

// print_r('Challenge 3: ' . challenge3() . PHP_EOL);

// Uncomment this when you have finished challenge 3
// print_r('Example 5 result: ' . example5() . PHP_EOL);

// print_r('Challenge 4 result: ' . challenge4() . PHP_EOL);
