# Gloversure PHP Challenge

## Setup Instructions
Refer to SETUP.md file for instructions.

## Description 
A new market store has recently opened and it's only selling three items, but it may add more in the future. 

The owner also wants to have special offers to help promote sales, but might want to change what offers are available later.

## Products

| Product SKU | Name            | Price      |
|-------------|-----------------|------------|
| ST01        | Strawberries    | £5.99      |
| CH01        | Chocolate Bar   | £2.99      |
| AP01        | Apple           | £0.50      |
    
## Challenges

1. Implement a buy one get one free offer on chocolate (This offer should scale if the customer purchases (e.g. buy 2 for the cost of 1, buy 4 for the cost of 2, etc etc).
2. Implement a bulk-buy offer on strawberries (If a customer buys 4 or more packets of strawberries, the price should be £3.99 per packet).
3. Implement a way to add new products and save them in the store.xml file

    | Product SKU | Name            | Quantity | Price      |
    |-------------|-----------------|----------|------------|
    | OR01        | Oranges         | 20       | £0.40      |
    | BA01        | Bacon           | 5        | £1.99      |

4. Implement a buy one get one free offer for Apples and Oranges; the cheaper item is free (This offer should scale if the customer purchases (e.g. buy 2 for the cost of 1, buy 4 for the cost of 2, etc etc).
5. Complete the test plan below.

## Extra Flair

1. Parse the inventory XML and store this against the product.
2. Implement a check that stops the user from adding more items to the basket than in the inventory.
3. Implement a checkout method on the basket that updates the stock quantities of the items in the basket.
4. Install PHPUnit and replace the tests in tests.php with PHPUnit tests.

## Test Plan

### Test 1

| Product SKU | Quantity | Expected Total | Actual Total |
|-------------|----------|----------------|--------------|
| CH01        | 2        | £2.99          |              |

### Test 2

| Product SKU | Quantity | Expected Total | Actual Total |
|-------------|----------|----------------|--------------|
| CH01        | 4        | £5.98          |              |

### Test 3

| Product SKU | Quantity | Expected Total | Actual Total |
|-------------|----------|----------------|--------------|
| ST01        | 6        | £23.94         |              |

### Test 4

| Product SKU | Quantity | Expected Total | Actual Total |
|-------------|----------|----------------|--------------|
| ST01, CH01  | 4, 4     | £21.98         |              |

## Test 5

| Product SKU | Expected Outcome               | Actual Outcome |
|-------------|--------------------------------|----------------|
| OR01, BA01  | Products with these SKUs exist |                |

### Test 6

| Product SKU | Quantity | Expected Total | Actual Total |
|-------------|----------|----------------|--------------|
| OR01, BA01  | 3, 2     | £5.18          |              |

## Running the Tests
To run the test simply run `php tests.php` from the command line