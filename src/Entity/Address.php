<?php

namespace App\Entity;

use App\Entity\Address\AddressInterface;
use App\Entity\Tax\TaxNP;
use App\Entity\Tax\TaxInterface;
use App\Entity\Tax\TaxPL;


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
     * @var string
     */
    private $country;

    /**
     * @var TaxInterface
     */
    private $taxStrategy;


    /**
     * Address constructor.
     * @param string $street
     * @param string $zip
     * @param string $city
     * @param string $country
     */
    public function __construct(string $street, string $zip, string $city, string $country)
    {
        $this->street  = $street;
        $this->zip     = $zip;
        $this->city    = $city;
        $this->country = $country;

        $this->chooseTaxStrategy();
    }

    private function chooseTaxStrategy()
    {
      // Wybór strategii w złym miejscu - powinien być poza Adresem
        switch ($this->country) {
            case self::PL:
                $this->taxStrategy = new TaxPL();
                break;
            default:
                $this->taxStrategy = new TaxNP();
        }
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
     * @return string
     */
    public function getCountry(): string
    {
        return $this->country;
    }

    /**
     * @return TaxInterface
     */
    public function getTaxStrategy(): TaxInterface
    {
        return $this->taxStrategy;
    }
}
