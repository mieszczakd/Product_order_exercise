<?php

namespace App\Service;

use App\Entity\Order;
use App\Manager\OrderManager;
use App\Repository\ProductRepository;


/**
 * Class OrderService
 * @package App\Service
 */
class OrderService
{
    /**
     * @var OrderManager
     */
    private $orderManager;

    /**
     * @var ProductRepository
     */
    private $productRepository;

    /**
     * OrderService constructor.
     * @param OrderManager $manager
     * @param ProductRepository $productRepository
     */
    public function __construct(OrderManager $manager, ProductRepository $productRepository)
    {
        $this->orderManager      = $manager;
        $this->productRepository = $productRepository;
    }

    /**
     * @param $productId
     * @param $quantity
     * @param $country
     *
     * @return Order
     *
     * @throws \Exception
     */
    // Co oznacza "OrderService::order()"? -> nie rozumiem jaka jest odpowiedzialność tej metody.
    // Może to powinien być OrderFactory::create()??
    // Opisałem w teście - product powinien być przekazywany do usługi, nie jego ID. I nie powinien to być jeden produkt.
    // Order mógłby być tworzony na bazie koszyka. Ale to może być jedna z metod tworzących dla fabryki.
    public function order($productId, $quantity, $country): Order
    {
        // Jak wyżej - Produkt, a nie ID
        $product = $this->productRepository->find($productId);

        // wtedy ten niezmiennik byłby zbędny
        if (null === $product) {
          // błąd powinien być domenowy - i zdefiniowana własna klasa wyjątku
          throw new \Exception('Product not found');
        }

        // Po co nam OrderManager? Albo po co nam orderService - mam wrażenie,
        // że odpowiedzialność tych klas powiela się o ile usuniesz z nich
        // kod związany z pobieraniem produktu, który nie powinien się w nim znaleźć
        $order = $this->orderManager->createOrder($product, $quantity, $country);

        // Niekoniecznie save/update -> to jest factory de facto, więc powinien zostać stworzony, nie widzę potrzeby persystancji w tej klasie
        //  save order
        //  update product

        return $order;
    }
}
