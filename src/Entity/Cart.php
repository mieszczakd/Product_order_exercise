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
    }

    public function isValid(): bool
    {
        foreach ($this->orderedItemsCollection as $item) {
            if (!$item->isValid()) {
                return false;
            }
        }
        return true;
    }

}