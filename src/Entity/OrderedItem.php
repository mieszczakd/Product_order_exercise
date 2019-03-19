<?php

namespace App\Entity;


/**
 * Class OrderedItem
 * @package App\Entity
 */
class OrderedItem
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
     * @var array
     */
    private $errors = [];


    /**
     * OrderedItem constructor.
     * @param Product|null $product
     * @param int $quantity
     */
    public function __construct(?Product $product, int $quantity)
    {
        $this->product  = $product;
        $this->quantity = $quantity;

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