<?php

namespace App\Entity\Customer;

use App\Entity\Address\AddressInterface;
use App\Entity\Tax\TaxForeign;
use App\Entity\Tax\TaxInterface;
use App\Entity\Tax\TaxPL;


/**
 * Class Order
 * @package App\Entity
 */
class Customer implements AddressInterface, CustomerInterface
{
    /**
     * @var string
     */
    private $email;

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
     * @var string
     */
    private $country;

    /**
     * @var TaxInterface
     */
    private $taxStrategy;


    /**
     * Customer constructor.
     * @param string $email
     * @param string $street
     * @param string $zip
     * @param string $city
     * @param string $country
     */
    public function __construct(string $email, string $street, string $zip, string $city, string $country)
    {
        $this->email   = $email;
        $this->street  = $street;
        $this->zip     = $zip;
        $this->city    = $city;
        $this->country = $country;

        if ($country === self::PL) {
            $this->taxStrategy = new TaxPL();
        } else {
            $this->taxStrategy = new TaxForeign();
        }
    }

    /**
     * @param $net
     * @return float
     */
    public function getTaxPrice($net): float
    {
        return $this->tax->count($net);
    }

    /**
     * @return string
     */
    public function getEmail(): string
    {
        return $this->email;
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
     * @return string
     */
    public function getCountry(): string
    {
        return $this->country;
    }

}