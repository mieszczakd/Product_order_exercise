<?php

namespace App\Entity;

use App\Collection\OrderedItemsCollection;
use App\Entity\Customer;
use App\Exception\EmptyCartException;
use App\Exception\InvalidCartException;


/**
 * Class Order
 * @package App\Entity
 */
class Order implements Timestampable, TotalInterface
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
     * @var OrderedItemsCollection
     */
    private $orderedItemsCollection;

    /**
     * @var Customer
     */
    private $customer;

    /**
     * @todo implement unique number
     *
     * @var string
     */
    private $number;

    /**
     * @var \DateTime
     */
    private $createdAt;


    /**
     * Order constructor.
     * @param Cart $cart
     *
     * @throws EmptyCartException
     * @throws InvalidCartException
     */
    public function __construct(Cart $cart)
    {
        if ($cart->isEmpty()) {
            throw new EmptyCartException('Cannot order empty cart');
        }
        if (!$cart->isValid()) {
            throw new InvalidCartException('Cannot order invalid cart');
        }

        $this->cart     = $cart;
        $this->customer = $cart->getCustomer();
        $this->orderedItemsCollection = $cart->getOrderedItemsCollection();

        $this->createdAt = new \DateTime();
        $this->number    = $this->generateNumber();
    }

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @return Cart
     */
    public function getCart(): Cart
    {
        return $this->cart;
    }

    /**
     * @return OrderedItemsCollection
     */
    public function getOrderedItemsCollection(): OrderedItemsCollection
    {
        return $this->orderedItemsCollection;
    }

    /**
     * @return Customer
     */
    public function getCustomer(): Customer
    {
        return $this->customer;
    }

    /**
     * @return string
     */
    public function getNumber(): string
    {
        return $this->number;
    }

    /**
     * @return \DateTime
     */
    public function getCreatedAt(): \DateTime
    {
        return $this->createdAt;
    }

    /**
     * @return float
     */
    public function getTotalNet(): float
    {
        return $this->cart->getTotalNet();
    }

    /**
     * @return float
     */
    public function getTotalGross(): float
    {
        return $this->cart->getTotalGross();
    }

    /**
     * @return float
     */
    public function getTaxPrice(): float
    {
        return $this->cart->getTaxPrice();
    }

    /**
     * @return string
     */
    private function generateNumber(): string
    {
        return '';
    }
}