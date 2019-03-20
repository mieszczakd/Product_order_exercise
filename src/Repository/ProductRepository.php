<?php

namespace App\Repository;

use App\Entity\Product;


/**
 * Class ProductRepository
 * @package App\Repository
 */
class ProductRepository
{

    // Implementacja jest zbędna dla repozytorium
    // Dla celów testowych wystarczyłby interface. Impementacja i tak będzie związana z jakąś konkretną biblioteką, np. Doctrinem

    /**
     * @param int $productId
     * @return Product|null
     */
    public function find( int $productId ): ?Product
    {
        $testProducts = $this->getTestProducts();

        // Jeśli już $productId === indeks elementu w tablicy, to zadeklaruj go jawnie
        // Teraz masz ID == 0 :)
        return array_key_exists($productId, $testProducts) ? $testProducts[$productId]: null;
    }

    public function getTestProducts(): array
    {
        return [
            new Product('Samsung', 3000, 0.23, 100),
            new Product('Sony', 2000, 0.23, 100),
            new Product('Siemens', 1500, 0.23, 100),
            new Product('Apple', 2000, 0.23, 100),
            new Product('Asus', 2000, 0.23, 100),
        ];
    }
}
