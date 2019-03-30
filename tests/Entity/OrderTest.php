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
            // Jak już wspominałem - tutaj powinien być dodawany Product z dodatkowymi informacjami, nie OrderItem
            $cart->addItem(new OrderedItem($product, 2, $this->polishCustomer));
        }

        // PRAWIE super. fajnie że tworzysz zamównienie przez koszyk i korzystasz ze wzorca fabryki
        // Co można było zrobić lepiej? Zrobić fabrykę jako service i ją wstrzykiwać.
        // Nie twórz sztywnych zależności. Jeśli już statyczny, to tylko konstruktor
        // Poczytaj na temat "named constructor", w tym przypadku wyglądałoby to tak: $order = Order::fromCart($cart);
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
      // Własne klasy wyjątków - awsome! :)
      // A teraz sprzedam Ci jeszcze dwa tipy.
      // 1) Sam exception to za mało - brakuje Ci komunikatu błedu
      // 2) Sam tekst to też często za mało - warto dodawać kody błędu

      // I teraz - jak to zrobić "fajnie" - np właśnie przez named constructor
      // throw CartException::empty() -> co się tutaj stało - tworzysz KLASĘ wyjątku, a nie wyjątek dla tego jednego, szczególnego przypadku
      // Dzięki temu, że masz dedykowany konstruktor, możesz sobie w tej metodzie konsukcyjnej zdefiniować message oraz code dla tego wyjątku
        $this->expectException(EmptyCartException::class);
        $cart  = new Cart($this->polishCustomer);
        $order = OrderFactory::create($cart);
    }

    public function testExceptionIfOrderInvalidCart()
    {
      // InvalidCart - to nic nie znaczy. Jest nieporawny - ale DLACZEGO?
      // Brakuje informacji kontekstowej - stwierdzenie, że "nie działa" to za mało
        $this->expectException(InvalidCartException::class);
        $cart  = new Cart($this->polishCustomer);
        $cart->addItem(new OrderedItem($this->products[0], 101, $this->polishCustomer));
        $order = OrderFactory::create($cart);
    }

}
