<?php
declare(strict_types=1);

use PHPUnit\Framework\TestCase;
use App\Entity\Address\Address;
use App\Entity\Country;


class AddressTest extends TestCase
{
    public function testCreatePolishAddress(): void
    {
        $address = new Address('Konwaliowa 13', '34-300', 'Żywiec', new Country('Poland', 'PL'));

        $this->assertInstanceOf(Address::class, $address);
        $this->assertEquals('Konwaliowa 13', $address->getStreet());
        $this->assertEquals('34-300', $address->getZip());
        $this->assertEquals('Żywiec', $address->getCity());
        $this->assertInstanceOf(Country::class, $address->getCountry());
    }

    public function testCreateEuropeanAddress(): void
    {
        $address = new Address('Hasičská 2', '018 41', 'Dubnica nad Váhom', new Country('Slovakia', 'SK'));

        $this->assertInstanceOf(Address::class, $address);
        $this->assertEquals('Hasičská 2', $address->getStreet());
        $this->assertEquals('018 41', $address->getZip());
        $this->assertEquals('Dubnica nad Váhom', $address->getCity());
        $this->assertInstanceOf(Country::class, $address->getCountry());
    }

    public function testCreateAddressOutsideEU(): void
    {
        $address = new Address('Jørgen Moes gate 9', '4011', 'Stavanger', new Country('Norway', 'NO'));

        $this->assertInstanceOf(Address::class, $address);
        $this->assertEquals('Jørgen Moes gate 9', $address->getStreet());
        $this->assertEquals('4011', $address->getZip());
        $this->assertEquals('Stavanger', $address->getCity());
        $this->assertInstanceOf(Country::class, $address->getCountry());
    }

}
