<?php
declare(strict_types=1);

use PHPUnit\Framework\TestCase;
use App\Entity\Product;
use App\Exception\ProductNegativeQuantityException;
use App\Exception\InvalidVatException;


class ProductTest extends TestCase
{
    public function testCreate(): void
    {
        $product = new Product('Samsung', 1000, 0.23, 100);
        $this->assertInstanceOf(Product::class, $product);
        $this->assertIsFloat($product->getPrice());
        $this->assertIsInt($product->getQuantity());
        $this->assertGreaterThan(0, $product->getQuantity());
    }

    public function testExceptionIfNegativeQuantityGiven(): void
    {
        $this->expectException(ProductNegativeQuantityException::class);
        $product = new Product('Samsung', 1000, 0.23, -20);
    }

    public function testExceptionIfInvalidVatGiven(): void
    {
        $this->expectException(InvalidVatException::class);
        $product = new Product('Samsung', 1000, 23, 100);
    }

}