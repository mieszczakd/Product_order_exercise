<?php
declare(strict_types=1);

use PHPUnit\Framework\TestCase;
use App\Entity\Product;
use App\Entity\OrderedItem;
use App\Entity\Cart;
use App\Entity\Customer;
use App\Entity\Address;


class CartTest extends TestCase
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
        //Zamiast wartości, można użyć constów: Country::POLAND;
        $this->polishCustomer  = new Customer('test@test.com', new Address('Konwaliowa 13', '34-300', 'Żywiec', 'PL'));
        $this->foreignCustomer = new Customer('test@test.com', new Address('Hasičská 2', '018 41', 'Dubnica nad Váhom', 'SK'));
    }

    public function testCreateCartByPolishCustomer(): void
    {
        $cart = new Cart($this->polishCustomer);

        foreach ($this->products as $product) {
            /** @var Product $product */

            // Tutaj trochę pomieszanie pojęć.
            // Cart i OrderItem - Koszyk to jedno, element zamówienia do drugie.
            // Te pojęcia nie powinny być mieszane.

            // Również nie wywoływałbym tutaj jawnie tworzenia obiektu "orderItem"
            // Powinien być ukryty wewnątrz obiektu Cart/Order
            // Lepiej $cart->addItem($produt, 2)

            // Dwa - klient nie jest częścią elementu zamówienia, tylko zamówienia per se
            $cart->addItem(new OrderedItem($product, 2, $this->polishCustomer));
        }

        $this->assertInstanceOf(Cart::class, $cart);
        $this->assertEquals(713.68, $cart->getTaxPrice());
        $this->assertEquals(3102.9, $cart->getTotalNet());
        $this->assertEquals(3816.58, $cart->getTotalGross());
    }

    public function testCreateItemByForeignCustomer(): void
    {
        $cart = new Cart($this->polishCustomer);

        foreach ($this->products as $product) {
            /** @var Product $product */
            $cart->addItem(new OrderedItem($product, 2, $this->foreignCustomer));
        }

        $this->assertInstanceOf(Cart::class, $cart);
        $this->assertEquals(0, $cart->getTaxPrice());
        $this->assertEquals(3102.9, $cart->getTotalNet());
        $this->assertEquals(3102.9, $cart->getTotalGross());
    }
}
