<?php

namespace Database\Seeders;

use App\Models\FarmerProfile;
use App\Models\Product;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class FarmerSeeder extends Seeder
{
    public function run(): void
    {
        // Farmer 1 — Marko Petrović, vegetables
        $marko = User::create([
            'name'             => 'Marko Petrović',
            'email'            => 'marko@example.com',
            'password'         => Hash::make('password'),
            'role'             => 'farmer',
            'phone'            => '+38765100200',
            'viber'            => '+38765100200',
            'whatsapp'         => '+38765100200',
            'onboarding_step'  => null,
        ]);

        FarmerProfile::create([
            'user_id'     => $marko->id,
            'farm_name'   => 'Organsko imanje Petrović',
            'description' => 'Uzgajamo organsko povrće bez pesticida na 3 hektara u okolici Prnjavora. Svježe ubrano svako jutro.',
            'location'    => 'Prnjavor',
            'is_active'   => true,
        ]);

        Product::create([
            'user_id'    => $marko->id,
            'category'   => 'povrce',
            'name'       => 'Paradajz organski',
            'description'=> 'Sočni organsko uzgojeni paradajz, sorti "beef" i "cherry". Bez hemije.',
            'price'      => 2.50,
            'price_unit' => 'kg',
            'fresh_today'=> true,
            'is_active'  => true,
        ]);

        Product::create([
            'user_id'    => $marko->id,
            'category'   => 'povrce',
            'name'       => 'Paprika babura',
            'description'=> 'Crvena i žuta babura, odlična za punjenje i salate.',
            'price'      => 1.80,
            'price_unit' => 'kg',
            'fresh_today'=> true,
            'is_active'  => true,
        ]);

        Product::create([
            'user_id'    => $marko->id,
            'category'   => 'povrce',
            'name'       => 'Crni luk',
            'description'=> 'Domaći crni luk, suho čuvan, traje do 6 mjeseci.',
            'price'      => 0.90,
            'price_unit' => 'kg',
            'fresh_today'=> false,
            'is_active'  => true,
        ]);

        // Farmer 2 — Ana Kovačević, dairy
        $ana = User::create([
            'name'             => 'Ana Kovačević',
            'email'            => 'ana@example.com',
            'password'         => Hash::make('password'),
            'role'             => 'farmer',
            'phone'            => '+38766200300',
            'viber'            => '+38766200300',
            'whatsapp'         => null,
            'onboarding_step'  => null,
        ]);

        FarmerProfile::create([
            'user_id'     => $ana->id,
            'farm_name'   => 'Mljekara Kovačević',
            'description' => 'Porodična farma sa 12 krava, svakog jutra svježe mlijeko i domaći sir. Tradicija od 1985. godine.',
            'location'    => 'Prnjavor - Konjuhovci',
            'is_active'   => true,
        ]);

        Product::create([
            'user_id'    => $ana->id,
            'category'   => 'mlijeko',
            'name'       => 'Svježe kravlje mlijeko',
            'description'=> 'Pasterizirano mlijeko sa naše farme, punjeno u staklenke od 1L. Preuzimanje svako jutro do 9h.',
            'price'      => 1.50,
            'price_unit' => 'l',
            'fresh_today'=> true,
            'is_active'  => true,
        ]);

        Product::create([
            'user_id'    => $ana->id,
            'category'   => 'mlijeko',
            'name'       => 'Domaći bijeli sir',
            'description'=> 'Mekani bijeli sir u salamuri, pravi domaći ukus.',
            'price'      => 8.00,
            'price_unit' => 'kg',
            'fresh_today'=> false,
            'is_active'  => true,
        ]);

        // Farmer 3 — Dragan Vujić, mixed
        $dragan = User::create([
            'name'             => 'Dragan Vujić',
            'email'            => 'dragan@example.com',
            'password'         => Hash::make('password'),
            'role'             => 'farmer',
            'phone'            => '+38763300400',
            'viber'            => '+38763300400',
            'whatsapp'         => '+38763300400',
            'onboarding_step'  => null,
        ]);

        FarmerProfile::create([
            'user_id'     => $dragan->id,
            'farm_name'   => 'Eko gazdinstov Vujić',
            'description' => 'Pčelarstvo, živinarstvo i povrtlarstvo. Sve što vam treba sa jednog mjesta — med, jaja i krompir.',
            'location'    => 'Prnjavor - Lišnja',
            'is_active'   => true,
        ]);

        Product::create([
            'user_id'    => $dragan->id,
            'category'   => 'med',
            'name'       => 'Livadski med',
            'description'=> 'Čisti livadski med sa planine Trebave. Bez dodavanja šećera, 100% prirodan.',
            'price'      => 15.00,
            'price_unit' => 'kg',
            'fresh_today'=> false,
            'is_active'  => true,
        ]);

        Product::create([
            'user_id'    => $dragan->id,
            'category'   => 'jaja',
            'name'       => 'Svježa seoska jaja',
            'description'=> 'Jaja slobodno pasenih kokoši, hranjenih prirodnom hranom. Žumanjak tamno narandžaste boje.',
            'price'      => 0.30,
            'price_unit' => 'kom',
            'fresh_today'=> true,
            'is_active'  => true,
        ]);

        Product::create([
            'user_id'    => $dragan->id,
            'category'   => 'povrce',
            'name'       => 'Krompir bijeli',
            'description'=> 'Domaći bijeli krompir, sorta "Desiree", bez prskanja.',
            'price'      => 0.70,
            'price_unit' => 'kg',
            'fresh_today'=> false,
            'is_active'  => true,
        ]);
    }
}
