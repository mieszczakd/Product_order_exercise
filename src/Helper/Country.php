<?php

// Klasy helper nie są dobrą praktyką.
// Kończą się tworzenie worków o zbyt szerokiej odpowiedzialności
// Wyglada trochę jak enum - przeniósłbym bliżej Encji albo wykorzystał consty w User Entity
namespace App\Helper;

/**
 * Class Country
 * @package App\Helper
 */
class Country
{
    const PL    = 'PL';
    const OTHER = 'OTHER';

    const COUNTRIES = [
        self::PL    => self::PL,
        self::OTHER => self::OTHER,
    ];
}
