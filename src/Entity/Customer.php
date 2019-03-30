<?php

namespace App\Entity;


use App\Entity\Tax\TaxInterface;
use App\Exception\InvalidEmailException;

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
     * @param string $email
     * @param Address $address
     *
     * @throws InvalidEmailException
     */
    public function __construct(string $email, Address $address)
    {
        // W teście opisałem Ci jak można inaczej konstruować Exception
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            throw new InvalidEmailException();
        }

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
