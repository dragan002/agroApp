<?php

namespace App\Enums;

class ProductCategory
{
    const VALUES = [
        'povrce', 'voce', 'mlijeko', 'meso', 'jaja',
        'med', 'zitarice', 'rakija', 'zimnica', 'ostalo'
    ];

    const LABELS = [
        'povrce'   => 'Povrće',
        'voce'     => 'Voće',
        'mlijeko'  => 'Mlijeko i mliječni',
        'meso'     => 'Meso i prerađevine',
        'jaja'     => 'Jaja',
        'med'      => 'Med i pčelinji',
        'zitarice' => 'Žitarice i brašno',
        'rakija'   => 'Rakija i alkohol',
        'zimnica'  => 'Zimnica',
        'ostalo'   => 'Ostalo',
    ];

    public static function isValid(string $value): bool
    {
        return in_array($value, self::VALUES);
    }

    public static function all(): array
    {
        return self::LABELS;
    }
}
