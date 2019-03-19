<?php

namespace App\Entity\Customer;


/**
 * Interface CustomerInterface
 * @package App\Entity\Customer
 */
interface CustomerInterface
{
    /**
     * Counts tax amount
     *
     * @param $net
     * @return float
     */
    public function getTaxPrice($net);
}