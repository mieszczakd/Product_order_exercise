<?php
declare(strict_types=1);

use PHPUnit\Framework\TestCase;
use App\Entity\Customer;
use App\Entity\Address\Address;
use App\Exception\InvalidEmailException;
use App\Entity\Country;


class CustomerTest extends TestCase
{
    public function testCreatePolishCustomer(): void
    {
        $customer = new Customer('test@test.com', new Address('Konwaliowa 13', '34-300', 'Żywiec', new Country('Poland', 'PL')));
        $this->assertInstanceOf(Customer::class, $customer);
    }

    public function testCreateEuropeanCustomer(): void
    {
        $customer = new Customer('test@test.com', new Address('Hasičská 2', '018 41', 'Dubnica nad Váhom', new Country('Slovakia', 'SK')));
        $this->assertInstanceOf(Customer::class, $customer);
    }

    public function testCreateCustomerOutsideEU(): void
    {
        $customer = new Customer('test@test.com', new Address('Jørgen Moes gate 9', '4011', 'Stavanger', new Country('Norway', 'NO')));
        $this->assertInstanceOf(Customer::class, $customer);
    }

    public function testExceptionIfInvalidEmailGiven()
    {
        $this->expectException(InvalidEmailException::class);
        $customer = new Customer('invalid', new Address('Konwaliowa 13', '34-300', 'Żywiec', new Country('Poland', 'PL')));
    }

}
