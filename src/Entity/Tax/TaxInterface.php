<?php

namespace App\Entity\Tax;


/**
 * Interface TaxInterface
 * @package App\Entity\Tax
 */
interface TaxInterface
{
    /**
     * Counts tax amount
     *
     * @param float $net
     * @param float $vat
     * @return float
     */
    public function calculate(float $net, float $vat): float;
}