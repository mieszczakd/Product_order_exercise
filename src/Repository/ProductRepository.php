<?php

namespace App\Repository;

use App\Entity\Product;


/**
 * Class ProductRepository
 * @package App\Repository
 */
class ProductRepository
{

    /**
     * @param int $productId
     * @return Product|null
     */
    public function find( int $productId ): ?Product
    {
        $testProducts = $this->getTestProducts();

        return array_key_exists($productId, $testProducts) ? $testProducts[$productId] : null;
    }

    /**
     * @param array $ids
     * @return Product[]
     */
    public function findByIds(array $ids): array
    {
        $products     = [];
        $testProducts = $this->getTestProducts();

        foreach ($ids as $id) {
            if ( array_key_exists($id, $testProducts) ) {
                $products[$id] = $testProducts[$id];
            }
        }

        return $products;
    }

    public function getTestProducts(): array
    {
        return [
            1 => new Product('Samsung', 3000, 0.23, 100),
            2 => new Product('Sony', 2000, 0.23, 100),
            3 => new Product('Siemens', 1500, 0.23, 100),
            4 => new Product('Apple', 2000, 0.23, 100),
            5 => new Product('Asus', 2000, 0.23, 100),
        ];
    }
}