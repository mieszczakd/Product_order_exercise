<?php

namespace App\Entity;
use App\Entity\Tax\TaxInterface;


/**
 * Class OrderedItem
 * @package App\Entity
 */
class OrderedItem implements TotalInterface
{

    /**
     * @var Product|null
     */
    private $product;

    /**
     * @var int
     */
    private $quantity;

    /**
     * @var TaxInterface
     */
    private $taxStrategy;

    /**
     * @var array
     */
    private $errors = [];


    /**
     * OrderedItem constructor.
     * @param Product|null $product
     * @param int $quantity
     * @param TaxInterface $tax
     */
    public function __construct(?Product $product, int $quantity, TaxInterface $tax)
    {
        $this->product     = $product;
        $this->quantity    = $quantity;
        $this->taxStrategy = $tax;

        if (null === $product) {
            $this->addError('Product is not available');
        } elseif ($quantity > $product->getQuantity()) {
            $this->addError('Product is not available with provided quantity');
        }
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
    public function getTotalNet(): float
    {
        return round( $this->product->getPrice() * $this->quantity, 2 );
    }

    /**
     * @return float
     */
    public function getTotalGross(): float
    {
        return $this->getTotalNet() + $this->getTaxPrice();
    }

    /**
     * @return float
     */
    public function getTaxPrice(): float
    {
        return $this->taxStrategy->calculate( $this->product->getPrice(), $this->product->getVat() ) * $this->quantity;
    }

    /**
     * @return bool
     */
    public function isValid(): bool
    {
        return empty($this->errors);
    }

    /**
     * @param string $error
     */
    private function addError(string $error)
    {
        $this->errors[] = $error;
    }


}