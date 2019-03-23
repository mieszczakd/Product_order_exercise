<?php

namespace App\Entity\Address;


/**
 * Interface AddressInterface
 * @package App\Entity\Address
 */
interface CountryInterface
{
    const PL    = 'PL';
    const OTHER = 'OTHER';

    const COUNTRIES = [
        self::PL    => self::PL,
        self::OTHER => self::OTHER
    ];

    /**
     * @return string
     */
    public function getCountry(): string;
}