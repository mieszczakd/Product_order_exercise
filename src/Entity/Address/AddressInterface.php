<?php

namespace App\Entity\Address;


/**
 * Interface AddressInterface
 * @package App\Entity\Address
 */

 // Chyba za daleko poszedłeś z tym dziedziczeniem interfaceów - zupełnie niepotrzebna abstrakcja na Country
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
