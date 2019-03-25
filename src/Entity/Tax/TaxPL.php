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

     // Wartości vat mogą być różne, mamy 5%, 8%, 23% itd. Powinny być podawane do tej metody
     // Te wartości też się zmieniają - mamy wartość per produkt
    public function calculate(float $net, float $vat): float
    {
        return round($vat * $net, 2);
    }
}
