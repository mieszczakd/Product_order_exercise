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
        $order   = $this->orderService->order($productId, $quantity, $country);
        $product = $this->productRepository->find($productId);

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