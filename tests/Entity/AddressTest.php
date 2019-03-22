<?php
declare(strict_types=1);

use PHPUnit\Framework\TestCase;
use App\Entity\Tax\TaxPL;
use App\Entity\Tax\TaxNP;
use App\Entity\Address;


class AddressTest extends TestCase
{
    public function testCreatePolishAddress(): void
    {
        $address = new Address('Konwaliowa 13', '34-300', 'Żywiec', 'PL');
        $this->assertInstanceOf(TaxPL::class, $address->getTaxStrategy());
    }

    public function testCreateForeignAddress(): void
    {
        $address = new Address('Hasičská 2', '018 41', 'Dubnica nad Váhom', 'SK');
        $this->assertInstanceOf(TaxNP::class, $address->getTaxStrategy());
    }

}