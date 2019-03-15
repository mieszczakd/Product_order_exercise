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
        return 0.23 * $net;
    }
}