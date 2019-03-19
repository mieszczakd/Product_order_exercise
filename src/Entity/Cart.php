<?php

namespace App\Entity;

use App\Collection\OrderedItemsCollection;


/**
 * Class Cart
 * @package App\Entity
 */
class Cart
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

}