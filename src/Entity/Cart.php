<?php

namespace App\Entity;

use App\Collection\Collection;


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
     * @var Collection
     */
    private $orderedItemsCollection;


    /**
     * Cart constructor.
     * @param Customer $customer
     */
    public function __construct(Customer $customer)
    {
        $this->customer               = $customer;
        $this->orderedItemsCollection = new Collection([]);
    }

    /**
     * @return Customer
     */
    public function getCustomer(): Customer
    {
        return $this->customer;
    }

    /**
     * @return Collection
     */
    public function getOrderedItemsCollection(): Collection
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

        // Nie zwracaj $this - tzw FluentInteface są akceptowalne tylko dla tzw Builderów
        return $this;
    }

    /**
     * @return bool
     */

   // Ta metoda jest zbędna
   // Walidacja danych powinna odbyć się na poziomie tworzenia obiektu
   // Metoda isValid w tym przypadku jęst błędna. To nie jest odpowiedzialność biznesowe tej klasy, aby mówić, czy jest, czy nie jest poprawna
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
