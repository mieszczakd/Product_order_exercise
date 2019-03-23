<?php

namespace App\Entity\Address;


/**
 * Interface AddressInterface
 * @package App\Entity\Address
 */
interface AddressInterface extends CountryInterface
{
    /**
     * @return string
     */
    public function getStreet(): string;

    /**
     * @return string
     */
    public function getZip(): string;

    /**
     * @return string
     */
    public function getCity(): string;
}