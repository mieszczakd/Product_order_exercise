<?php

namespace App\Entity\Tax;


/**
 * Class TaxPL
 * @package App\Entity\Tax
 */
class TaxPL implements TaxInterface
{
    /**
     * @param float $net
     * @param float $vat
     * @return float
     */
    public function calculate(float $net, float $vat): float
    {
        return round(0.23 * $net, 2);
    }
}