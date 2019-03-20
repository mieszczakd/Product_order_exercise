<?php

namespace App\Entity;


/**
 * Interface TotalInterface
 * @package App\Entity
 */
interface TotalInterface
{
    /**
     * @return float
     */
    public function getTotalNet(): float;

    /**
     * @return float
     */
    public function getTotalGross(): float;

    /**
     * @return float
     */
    public function getTaxPrice(): float;
}