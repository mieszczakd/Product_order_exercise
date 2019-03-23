<?php

namespace App\Strategy\Tax;

/**
 * Class TaxPL
 * @package App\Helper\Tax
 */
class TaxPL implements TaxInterface
{
    /**
     * @param $net
     * @return float
     */
    public function count($net)
    {

        // Wchodzimy w wartości zmienno przecinkowe.
        // Aby mieć poprawnie wyliczone sumy powinieneś policzyć podatek jednostkowo - per produktu,
        // a następnie (po zaokrągleniu) przemnożyć go przez ilość produktów.
        // Każdy produkt oczywiście osobno.

        // Takie podejście będzie skutkowało błędami zaokrągleń i uciekaniem grosików
        return 0.23 * $net;
    }
}
