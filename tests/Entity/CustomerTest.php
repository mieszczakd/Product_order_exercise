<?php
declare(strict_types=1);

use PHPUnit\Framework\TestCase;
use App\Entity\Customer;
use App\Entity\Address;
use App\Exception\InvalidEmailException;

// Trochę chudziutki ten test
class CustomerTest extends TestCase
{
    public function testCreate(): void
    {
        $customer = new Customer('test@test.com', new Address('Konwaliowa 13', '34-300', 'Żywiec', 'PL'));
        $this->assertInstanceOf(Customer::class, $customer);
    }

    public function testExceptionIfInvalidEmailGiven()
    {
        $this->expectException(InvalidEmailException::class);
        $customer = new Customer('invalid', new Address('Konwaliowa 13', '34-300', 'Żywiec', 'PL'));
    }

}
