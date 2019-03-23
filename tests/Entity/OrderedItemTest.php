<?php
declare(strict_types=1);

use PHPUnit\Framework\TestCase;
use App\Entity\Product;
use App\Entity\OrderedItem;
use App\Entity\Customer;
use App\Entity\Address;


class OrderedItemTest extends TestCase
{
    /**
     * @var Product
     */
    private $product;

    /**
     * @var Customer
     */
    private $foreignCustomer;

    /**
     * @var Customer
     */
    private $polishCustomer;


    public function setUp(): void
    {
        parent::setUp();

        $this->product = new Product('Samsung', 1000.99, 0.23, 100);

        $this->polishCustomer  = new Customer('test@test.com', new Address('Konwaliowa 13', '34-300', 'Żywiec', 'PL'));
        $this->foreignCustomer = new Customer('test@test.com', new Address('Hasičská 2', '018 41', 'Dubnica nad Váhom', 'SK'));
    }

    public function testCreateItemByPolishCustomer(): void
    {
        $orderedItem = new OrderedItem($this->product, 2, $this->polishCustomer);

        $this->assertInstanceOf(OrderedItem::class, $orderedItem);
        $this->assertEquals(460.46, $orderedItem->getTaxPrice());
        $this->assertEquals(2001.98, $orderedItem->getTotalNet());
        $this->assertEquals(2462.44, $orderedItem->getTotalGross());
    }

    public function testCreateItemByForeignCustomer(): void
    {
        $orderedItem = new OrderedItem($this->product, 2, $this->foreignCustomer);

        $this->assertInstanceOf(OrderedItem::class, $orderedItem);
        $this->assertEquals(0, $orderedItem->getTaxPrice());
        $this->assertEquals(2001.98, $orderedItem->getTotalNet());
        $this->assertEquals(2001.98, $orderedItem->getTotalGross());
    }

    public function testErrorIfNonProductGiven(): void
    {
        $orderedItem = new OrderedItem(null, 2, $this->foreignCustomer);

        $this->assertFalse($orderedItem->isValid());
        $this->assertTrue($orderedItem->hasError('Product is not available'));
    }

    public function testErrorIfNegativeQuantityGiven(): void
    {
        $orderedItem = new OrderedItem($this->product, -1, $this->foreignCustomer);

        $this->assertFalse($orderedItem->isValid());
        $this->assertTrue($orderedItem->hasError('Cannot order product with negative quantity'));
    }

    public function testErrorIfQuantityIsGreaterThanProductQuantity(): void
    {
        $orderedItem = new OrderedItem($this->product, 101, $this->foreignCustomer);

        $this->assertFalse($orderedItem->isValid());
        $this->assertTrue($orderedItem->hasError('Product is not available with provided quantity'));
    }

}