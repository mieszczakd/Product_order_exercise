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
     * @var Customer
     */
    private $customer;

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
     * @param Customer $customer
     *
     * @throws \Exception
     */
    public function __construct(?Product $product, int $quantity, Customer $customer)
    {
        if (null === $product) {
            $this->addError('Product is not available');
        } elseif ($quantity > $product->getQuantity()) {
            $this->addError('Product is not available with provided quantity');
        }
        if ($quantity < 0) {
            $this->addError('Cannot order product with negative quantity');
        }

        $this->product     = $product;
        $this->quantity    = $quantity;
        $this->customer    = $customer;
        $this->taxStrategy = $customer->getTaxStrategy();
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

    /**
     * @return array
     */
    public function getErrors(): array
    {
        return $this->errors;
    }

    /**
     * @param string $message
     * @return bool
     */
    public function hasError(string $message): bool
    {
        return in_array($message, $this->errors);
    }
}