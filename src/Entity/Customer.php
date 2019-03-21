<?php

namespace App\Entity;


use App\Entity\Tax\TaxInterface;

/**
 * Class Customer
 * @package App\Entity\Customer
 */
class Customer
{
    /**
     * @var string
     */
    private $email;

    /**
     * @var
     */
    private $address;


    /**
     * Customer constructor.
     * @param string $email
     * @param Address $address
     */
    public function __construct(string $email, Address $address)
    {
        $this->email   = $email;
        $this->address = $address;
    }

    /**
     * @return string
     */
    public function getEmail(): string
    {
        return $this->email;
    }

    /**
     * @return mixed
     */
    public function getAddress()
    {
        return $this->address;
    }

    /**
     * @return Tax\TaxInterface
     */
    public function getTaxStrategy(): TaxInterface
    {
        return $this->address->getTaxStrategy();
    }
}