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
    public function order($productId, $quantity, $country): Order
    {
        $product = $this->productRepository->find($productId);

        if (null === $product) {
          throw new \Exception('Product not found');
        }

        $order = $this->orderManager->createOrder($product, $quantity, $country);

        //  save order
        //  update product

        return $order;
    }
}