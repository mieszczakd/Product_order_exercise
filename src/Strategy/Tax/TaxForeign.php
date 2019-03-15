<?php

namespace App\Strategy\Tax;


/**
 * Class TaxForeign
 * @package App\Helper\Tax
 */
class TaxForeign implements TaxInterface
{
    /**
     * @param $net
     * @return float
     */
    public function count($net)
    {
        return 0;
    }
}