<?php

namespace App\Entity\Address;

use App\Entity\Country;


/**
 * Interface AddressInterface
 * @package App\Entity\Address
 */
interface AddressInterface
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

    /**
     * @return Country
     */
    public function getCountry(): Country;
}
