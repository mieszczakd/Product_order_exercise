<?php

namespace App\Entity\Tax;


/**
 * Class TaxForeign
 * @package App\Entity\Tax
 */
class TaxNP implements TaxInterface
{
    /**
     * @param float $net
     * @param float $vat
     * @return float
     */
    public function calculate(float $net, float $vat): float
    {
        return 0;
    }
}