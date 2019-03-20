<?php

namespace App\Entity;

use App\Collection\OrderedItemsCollection;
use App\Entity\Customer\Customer;


/**
 * Class Cart
 * @package App\Entity
 */
class Cart implements TotalInterface
{
    /**
     * @var Customer
     */
    private $customer;

    /**
     * @var OrderedItemsCollection
     */
    private $orderedItemsCollection;


    /**
     * Cart constructor.
     * @param Customer $customer
     * @param OrderedItemsCollection $collection
     */
    public function __construct(Customer $customer, OrderedItemsCollection $collection)
    {
        $this->customer               = $customer;
        $this->orderedItemsCollection = $collection;
    }

    /**
     * @return Customer
     */
    public function getCustomer(): Customer
    {
        return $this->customer;
    }

    /**
     * @return OrderedItemsCollection
     */
    public function getOrderedItemsCollection(): OrderedItemsCollection
    {
        return $this->orderedItemsCollection;
    }

    /**
     * @param OrderedItem $item
     * @return Cart
     */
    public function addItem(OrderedItem $item): Cart
    {
        $this->orderedItemsCollection->add($item);
        return $this;
    }

    /**
     * @return bool
     */
    public function isValid(): bool
    {
        foreach ($this->orderedItemsCollection as $item) {
            if (!$item->isValid()) {
                return false;
            }
        }
        return true;
    }

    /**
     * @return bool
     */
    public function isEmpty(): bool
    {
        return 0 === $this->orderedItemsCollection->count();
    }

    /**
     * @return float
     */
    public function getTotalNet(): float
    {
        $total = 0;
        foreach ($this->orderedItemsCollection as $orderedItem) {
            /** @var OrderedItem $orderedItem */
            $total += $orderedItem->getTotalNet();
        }

        return $total;
    }

    /**
     * @return float
     */
    public function getTotalGross(): float
    {
        $total = 0;
        foreach ($this->orderedItemsCollection as $orderedItem) {
            /** @var OrderedItem $orderedItem */
            $total += $orderedItem->getTotalGross();
        }

        return $total;
    }

    /**
     * @return float
     */
    public function getTaxPrice(): float
    {
        $total = 0;
        foreach ($this->orderedItemsCollection as $orderedItem) {
            /** @var OrderedItem $orderedItem */
            $total += $orderedItem->getTaxPrice();
        }

        return $total;
    }


}