<?php
declare(strict_types=1);

use PHPUnit\Framework\TestCase;
use App\Factory\OrderFactory;
use App\Entity\Product;
use App\Entity\Customer;
use App\Entity\Address;
use App\Entity\Cart;
use App\Entity\OrderedItem;
use App\Entity\Order;
use App\Exception\EmptyCartException;
use App\Exception\InvalidCartException;


class OrderTest extends TestCase
{
    /**
     * @var Product[]
     */
    private $products;

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

        $this->products = [
            new Product('Samsung', 1000.99, 0.23, 100),
            new Product('Asus', 550.46, 0.23, 100),
        ];

        $this->polishCustomer  = new Customer('test@test.com', new Address('Konwaliowa 13', '34-300', 'Żywiec', 'PL'));
        $this->foreignCustomer = new Customer('test@test.com', new Address('Hasičská 2', '018 41', 'Dubnica nad Váhom', 'SK'));
    }

    public function testOrderByPolishCustomer(): void
    {
        $cart = new Cart($this->polishCustomer);

        foreach ($this->products as $product) {
            /** @var Product $product */
            $cart->addItem(new OrderedItem($product, 2, $this->polishCustomer));
        }

        $order = OrderFactory::create($cart);

        $this->assertInstanceOf(Order::class, $order);
        $this->assertEquals(713.68, $order->getTaxPrice());
        $this->assertEquals(3102.9, $order->getTotalNet());
        $this->assertEquals(3816.58, $order->getTotalGross());
        $this->assertEquals(98, $this->products[0]->getQuantity());
        $this->assertEquals(98, $this->products[1]->getQuantity());
    }

    public function testOrderByForeignCustomer(): void
    {
        $cart = new Cart($this->polishCustomer);

        foreach ($this->products as $product) {
            /** @var Product $product */
            $cart->addItem(new OrderedItem($product, 2, $this->foreignCustomer));
        }

        $order = OrderFactory::create($cart);

        $this->assertInstanceOf(Order::class, $order);
        $this->assertEquals(0, $order->getTaxPrice());
        $this->assertEquals(3102.9, $order->getTotalNet());
        $this->assertEquals(3102.9, $order->getTotalGross());
        $this->assertEquals(98, $this->products[0]->getQuantity());
        $this->assertEquals(98, $this->products[1]->getQuantity());
    }

    public function testExceptionIfOrderEmptyCart()
    {
        $this->expectException(EmptyCartException::class);
        $cart  = new Cart($this->polishCustomer);
        $order = OrderFactory::create($cart);
    }

    public function testExceptionIfOrderInvalidCart()
    {
        $this->expectException(InvalidCartException::class);
        $cart  = new Cart($this->polishCustomer);
        $cart->addItem(new OrderedItem($this->products[0], 101, $this->polishCustomer));
        $order = OrderFactory::create($cart);
    }

}