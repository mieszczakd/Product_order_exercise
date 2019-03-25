<?php

namespace App\Entity\Address;


/**
 * Interface AddressInterface
 * @package App\Entity\Address
 */

 // Co to za inteface Country? Interface mówi o zachowaniu obiektów, które implementując dany interface
 // Nie wiem jakie zachowanie zdradza ten inteface - jaki jest jego cel???
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
