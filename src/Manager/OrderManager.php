<?php

namespace App\Manager;

use App\Entity\Order;
use App\Entity\Product;

/**
 * Class OrderManager
 * @package App\Manager
 */
class OrderManager
{

    /**
     * @param Product $product
     * @param int $quantity
     * @param string $country
     *
     * @return Order
     *
     * @throws \Exception
     */
    public function createOrder(Product $product, int $quantity, string $country): Order
    {
        return new Order($product, $quantity, $country);
    }

}