<?php

namespace App\Entity;

use App\Helper\Country;
use App\Strategy\Tax\TaxForeign;
use App\Strategy\Tax\TaxInterface;
use App\Strategy\Tax\TaxPL;


/**
 * Class Order
 * @package App\Entity
 */
class Order extends Timestampable
{

    /**
     * @var int
     */
    private $id;

    /**
     * @var Cart
     */
    private $cart;

    /**
     * @todo implement unique number
     *
     * @var string
     */
    private $number;


    /**
     * Order constructor.
     * @param Cart $cart
     * @throws \Exception
     */
    public function __construct(Cart $cart)
    {
        parent::__construct();

        $this->cart = $cart;
    }

}