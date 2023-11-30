<?php declare(strict_types=1);

use PHPUnit\Framework\TestCase;

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

final class Tests extends TestCase
{
    private $store;
    private $path;

    protected function setUp(): void
    {
        $this->path = [
            __DIR__,
            'xml',
            'store.xml',
        ];

        $this->store = new \Gloversure\Store\Store(implode(DIRECTORY_SEPARATOR, $this->path));
    }

    public function test1(): void
    {
        $basket = new \Gloversure\Store\Basket();

        $basket->addItems(
            $this->store->getProduct('CH01'),
            2
        );
        $basket->checkout(implode(DIRECTORY_SEPARATOR, $this->path));

        $this->assertSame(2.99, $basket->total);
    }

    public function test2(): void
    {
        $basket = new \Gloversure\Store\Basket();

        $basket->addItems(
            $this->store->getProduct('CH01'),
            4
        );
        $basket->checkout(implode(DIRECTORY_SEPARATOR, $this->path));

        $this->assertSame(5.98, $basket->total);
    }
    
    public function test3(): void
    {        
        $basket = new \Gloversure\Store\Basket();

        $basket->addItems(
            $this->store->getProduct('ST01'),
            6
        );
        $basket->checkout(implode(DIRECTORY_SEPARATOR, $this->path));

        $this->assertSame(23.94, $basket->total);
    }

    public function test4(): void
    {        
        $basket = new \Gloversure\Store\Basket();

        $basket->addItems(
            $this->store->getProduct('ST01'),
            4
        );
        $basket->addItems(
            $this->store->getProduct('CH01'),
            4
        );
        $basket->checkout(implode(DIRECTORY_SEPARATOR, $this->path));

        $this->assertSame(21.94, $basket->total);
    }

    public function test5(): void
    {        
        $orange = $this->store->getProduct('OR01');    
        $bacon = $this->store->getProduct('BA01');

        $this->assertSame('OR01', $orange->sku);
        $this->assertSame('BA01', $bacon->sku);
    }

    public function test6(): void
    {        
        $basket = new \Gloversure\Store\Basket();

        $basket->addItems(
            $this->store->getProduct('OR01'),
            3
        );
        $basket->addItems(
            $this->store->getProduct('BA01'),
            2
        );
        $basket->checkout(implode(DIRECTORY_SEPARATOR, $this->path));

        $this->assertSame(5.18, $basket->total);
    }

}
