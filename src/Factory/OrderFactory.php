<?php

namespace App\Factory;

use App\Entity\Cart;
use App\Entity\Order;
use App\Exception\EmptyCartException;
use App\Exception\InvalidCartException;


/**
 * Class OrderFactory
 * @package App\Factory
 */
class OrderFactory
{

    /**
     * @param Cart $cart
     *
     * @return Order
     *
     * @throws EmptyCartException
     * @throws InvalidCartException
     */
    static public function create(Cart $cart): Order
    {
        return new Order($cart);
    }
}