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

        // Strategia wyboru powinna być dobrana w oparciu o kraj, ale to nie jest odpowiedzialność klasy Address
        // Odpowiedzialnością adresu jest trzymanie informacji adresowych, nie musi (a nawet nie może!) wiedzieć niczego nt strategii rozliczenia zamówienia
        // Adres może zostać użyty w innym kontekście, który nie ma nic wspólnego z zamówieniami
        $this->assertInstanceOf(TaxPL::class, $address->getTaxStrategy());
    }


    // Brakuje mi jeszcze jednego przypadku, isEU - pisałem Ci chyba o tym w poprzednim MR
    // VAT liczymy inaczej dla PL, inaczej dla EU i inaczej dla krajów z poza UE
    public function testCreateForeignAddress(): void
    {
        $address = new Address('Hasičská 2', '018 41', 'Dubnica nad Váhom', 'SK');
        $this->assertInstanceOf(TaxNP::class, $address->getTaxStrategy());
    }

}
