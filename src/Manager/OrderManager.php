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
        // To samo co przy OrderService- sposób konstrukcji jest z góry skazany na przebudowę.
        // W kontruktorze $county byłoby ok, ale przekazywanie elementów zamówienia powinno zostać w innym sposób zrealizowane.
        return new Order($product, $quantity, $country);
    }

}
