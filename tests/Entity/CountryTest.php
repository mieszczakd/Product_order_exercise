<?php
declare(strict_types=1);

use PHPUnit\Framework\TestCase;
use App\Entity\Country;


class CountryTest extends TestCase
{
    public function testCreateCountryPL(): void
    {
        $country = new Country('Poland','PL');

        $this->assertInstanceOf(Country::class, $country);
        $this->assertTrue($country->isPL());
        $this->assertTrue($country->isEU());
        $this->assertEquals('Poland', $country->getName());
        $this->assertEquals('PL', $country->getCode());
    }

    public function testCreateCountryEU(): void
    {
        $country = new Country('Czech Republic','CZ');

        $this->assertInstanceOf(Country::class, $country);
        $this->assertFalse($country->isPL());
        $this->assertTrue($country->isEU());
        $this->assertEquals('Czech Republic', $country->getName());
        $this->assertEquals('CZ', $country->getCode());
    }

    public function testCreateCountryOutsideEU(): void
    {
        $country = new Country('Canada','CA');

        $this->assertInstanceOf(Country::class, $country);
        $this->assertFalse($country->isPL());
        $this->assertFalse($country->isEU());
        $this->assertEquals('Canada', $country->getName());
        $this->assertEquals('CA', $country->getCode());
    }

}
