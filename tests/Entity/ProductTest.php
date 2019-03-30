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

        $this->assertEquals('Samsung', $product->getName());
        $this->assertEquals(1000, $product->getPrice());
        $this->assertEquals(0.23, $product->getVat());
        $this->assertEquals(100, $product->getQuantity());
        $this->assertIsInt($product->getQuantity());
        $this->assertGreaterThan(0, $product->getQuantity());
    }

    public function testExceptionIfNegativeQuantityGiven(): void
    {

        // To samo co opisałem Ci wcześniej - ProductException::negativeQuantity()
        $this->expectException(ProductNegativeQuantityException::class);
        $product = new Product('Samsung', 1000, 0.23, -20);
    }

    public function testReduceQuantity()
    {
        $product = new Product('Samsung', 1000, 0.23, 100);
        $product->reduceQuantity(20);

        $this->assertEquals(80, $product->getQuantity());
    }

    public function testExceptionIfInvalidVatGiven(): void
    {
        $this->expectException(InvalidVatException::class);
        // Nie wiem, czy nie wolalłbym jednak notacji "23", zamiast "0.23"
        $product = new Product('Samsung', 1000, 23, 100);
    }

    public function testExceptionIfReducedQuantityIsGreaterThanProductQuantity(): void
    {
        // Jak wyżej :)
        $this->expectException(ProductNegativeQuantityException::class);
        $product = new Product('Samsung', 1000, 0.23, 100);
        $product->reduceQuantity(101);
    }

}
