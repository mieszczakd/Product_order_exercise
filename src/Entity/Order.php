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
 // implements
class Order extends Timestampable
{

    /**
     * @var int
     */
    private $id;

    /**
     * @var Product
     */
    private $product;

    /**
     * @var int
     */
    private $quantity;

    /**
     * @var TaxInterface
     */
    private $tax;

    /**
     * @todo implement unique number
     *
     * @var string
     */
    private $number;


    /**
     * Order constructor.
     *
     * @param Product $product
     * @param int $quantity
     * @param string $country
     *
     * @throws \Exception
     */
    public function __construct(Product $product, int $quantity, string $country)
    {
        parent::__construct();

        // Zamówienie składa się zazwyczaj z elementów zamówienia
        $this->product  = $product;
        $this->quantity = $quantity;

        // Mógłbyś mieć metodę w stylu $product->reduceQuantity(5) i to w niej zawrzeć logikę walidacji.
        // Chyba, że zakładasz w swojej domenie to, aby stan magazynu był ujemny
        if ($quantity > $product->getQuantity()) {
            throw new \InvalidArgumentException('Product is not available with provided quantity');
        }

        // Nazwa tej metody nic mi nie mówi w kontekście Product.
        // Trochę też robi Ci się coupling - Produkt wie o Zamówieniu (orderQuantity), a nie powinien.
        $product->orderQuantity($quantity);

        // Może być też EU - w razie dojścia nowej strategii musisz znowu zmieniać kod klasy zamówienia i modyfikować testy
        // Zastanów się jak to zrobić lepiej :)
        if ($country === Country::PL) {
            $this->tax = new TaxPL();
        } else {
            $this->tax = new TaxForeign();
        }
    }

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @return Product
     */
    public function getProduct(): Product
    {
        return $this->product;
    }

    /**
     * @return int
     */
    public function getQuantity(): int
    {
        return $this->quantity;
    }

    /**
     * @return float
     */
    public function getTotalGross(): float
    {
        return $this->getTotalNet() + $this->getTax();
    }

    /**
     * @return float
     */
    public function getTotalNet(): float
    {

        return $this->quantity * $this->product->getPrice();
    }

    /**
     * @return float
     */
    public function getTax(): float
    {
      // Podatek nie "liczy", tylko bardziej "wylicza" - bliżej mu do calculate niż do count
        return $this->tax->count( $this->getTotalNet() );
    }

}
