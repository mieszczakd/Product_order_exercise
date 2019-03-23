<?php
declare(strict_types=1);

use App\Manager\OrderManager;
use App\Repository\ProductRepository;
use App\Service\OrderService;
use PHPUnit\Framework\TestCase;
use App\Helper\Country;
use App\Entity\Order;


class OrderServiceTest extends TestCase
{
    /**
     * @var OrderService
     */
    private $orderService;

    /**
     * @var ProductRepository
     */
    private $productRepository;


    public function setUp(): void
    {
        parent::setUp();

        $this->productRepository = new ProductRepository();
        $this->orderService      = new OrderService( new OrderManager(), $this->productRepository );
    }

    /**
     * @dataProvider orderByPolishCitizenCaseProvider
     */
    public function testOrderByPolishCitizen($productId, $quantity, $country)
    {

        // Usługa powinna otrzymywać Product, a nie jego
        // Rozumiem również, że robisz najprostszą implementację, ale założenie jednego produktu przekazywanego na start do usługi, z góry jest błędne
        $order   = $this->orderService->order($productId, $quantity, $country);

        // Masz zaimplementowane repozytorium produktów - powinieneś oprzeć się tutaj na interfaceie a nie nie konkretnej implementacji
        // Idealnie w tym miejscu sprawdziłby się testing double - mock, który zwróciłby Ci dla danego ID obiekt Produktu
        $product = $this->productRepository->find($productId);

        // Te wartości muszą być w teście zdefiniowane, a nie wyliczane
        // To co robisz poniżej to wykonywanie kodu, który de facto testujesz.
        // Dublowanie kodu testowanego w teście jest jednym z grzechów głównych testów
        $netAmount   = $quantity * $product->getPrice();
        $tax         = ($quantity * $product->getPrice()) * 0.23;
        $grossAmount = ($quantity * $product->getPrice()) + ($quantity * $product->getPrice()) * 0.23;

        $this->assertInstanceOf(Order::class, $order);
        $this->assertEquals($quantity, $order->getQuantity());
        $this->assertEquals($netAmount, $order->getTotalNet());
        $this->assertEquals($tax, $order->getTax());
        $this->assertEquals($grossAmount, $order->getTotalGross());

    }

    /**
     * @dataProvider orderByOtherCountryCitizenCaseProvider
     */
    public function testOrderByOtherCountryCitizen($productId, $quantity, $country)
    {
        $order   = $this->orderService->order($productId, $quantity, $country);
        $product = $this->productRepository->find($productId);

        $netAmount   = $quantity * $product->getPrice();
        $tax         = 0;
        $grossAmount = $netAmount;

        $this->assertInstanceOf(Order::class, $order);
        $this->assertEquals($quantity, $order->getQuantity());
        $this->assertEquals($netAmount, $order->getTotalNet());
        $this->assertEquals($tax, $order->getTax());
        $this->assertEquals($grossAmount, $order->getTotalGross());

    }

    public function testExceptionIfProductIsNotAvailableWithProvidedQuantity()
    {
        // Dla własnych błędów domenowych warto tworzyć własną klasę wyjątków.
        // Łatwiej dorobić później globalne mechanizmy obsługi błędów, np. logowanie lub tranformowanie w response
        $this->expectException(\InvalidArgumentException::class);
        $this->expectExceptionMessage('Product is not available with provided quantity');
        $order = $this->orderService->order(2, 120, Country::PL);
    }

    public function orderByPolishCitizenCaseProvider()
    {
        yield [1, 20, Country::PL];
        yield [3, 20, Country::PL];
    }

    public function orderByOtherCountryCitizenCaseProvider()
    {
        yield [2, 50, Country::OTHER];
        yield [4, 20, Country::OTHER];
    }

}
