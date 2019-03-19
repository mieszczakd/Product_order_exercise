<?php

namespace App\Service;

use App\Collection\OrderedItemsCollection;
use App\Entity\Cart;
use App\Entity\Customer;
use App\Entity\Order;
use App\Entity\OrderedItem;
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
     * @param Customer $customer
     * @return Cart
     */
    public function createEmptyCart(Customer $customer): Cart
    {
        return new Cart($customer, new OrderedItemsCollection([]));
    }

    public function addItems(Cart $cart, array $items)
    {
        $ids = array_map(function ($item) {
            return $item['id'];
        }, $items);

        $products = $this->productRepository->findByIds($ids);

        foreach ($items as $item) {
            $product = null;
            if (array_key_exists($item['id'], $products)) {
                $product = $products[$item['id']];
            }

            $cart->addItem( new OrderedItem($product, $item['quantity']) );
        }
        return $cart;
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