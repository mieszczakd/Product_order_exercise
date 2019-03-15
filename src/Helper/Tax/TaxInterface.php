<?php

namespace App\Helper\Tax;


/**
 * Interface TaxInterface
 * @package App\Helper\Tax
 */
interface TaxInterface
{
    /**
     * Counts tax amount
     *
     * @param $net
     * @return float
     */
    public function count($net);
}