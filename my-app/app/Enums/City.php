<?php

namespace App\Enums;

class City
{
    const VALUES = [
        'prnjavor', 'doboj', 'banja_luka', 'bijeljina', 'trebinje',
        'prijedor', 'zvornik', 'srbac', 'celinac', 'laktasi',
        'derventa', 'gradiska', 'modrica', 'kotor_varos', 'foca',
        'istocno_sarajevo', 'brcko', 'mrkonjic_grad',
    ];

    const LABELS = [
        'prnjavor'          => 'Prnjavor',
        'doboj'             => 'Doboj',
        'banja_luka'        => 'Banja Luka',
        'bijeljina'         => 'Bijeljina',
        'trebinje'          => 'Trebinje',
        'prijedor'          => 'Prijedor',
        'zvornik'           => 'Zvornik',
        'srbac'             => 'Srbac',
        'celinac'           => 'Čelinac',
        'laktasi'           => 'Laktaši',
        'derventa'          => 'Derventa',
        'gradiska'          => 'Gradiška',
        'modrica'           => 'Modriča',
        'kotor_varos'       => 'Kotor Varoš',
        'foca'              => 'Foča',
        'istocno_sarajevo'  => 'Istočno Sarajevo',
        'brcko'             => 'Brčko',
        'mrkonjic_grad'     => 'Mrkonjić Grad',
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
