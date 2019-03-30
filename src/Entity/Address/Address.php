<?php

namespace App\Entity\Address;

use App\Entity\Country;


/**
 * Class Address
 * @package App\Entity
 */
class Address implements AddressInterface
{

    /**
     * @var int
     */
    private $id;

    /**
     * @var string
     */
    private $street;

    /**
     * @var string
     */
    private $zip;

    /**
     * @var string
     */
    private $city;

    /**
     * @var Country
     */
    private $country;


    /**
     * @param string $street
     * @param string $zip
     * @param string $city
     * @param Country $country
     */
    public function __construct(string $street, string $zip, string $city, Country $country)
    {
        $this->street  = $street;
        $this->zip     = $zip;
        $this->city    = $city;
        $this->country = $country;
    }


    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @return string
     */
    public function getStreet(): string
    {
        return $this->street;
    }

    /**
     * @return string
     */
    public function getZip(): string
    {
        return $this->zip;
    }

    /**
     * @return string
     */
    public function getCity(): string
    {
        return $this->city;
    }

    /**
     * @return Country
     */
    public function getCountry(): Country
    {
        return $this->country;
    }

}
