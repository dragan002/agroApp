<?php

namespace Database\Seeders;

use App\Models\FarmerProfile;
use App\Models\Photo;
use App\Models\Product;
use App\Models\Review;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Storage;

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

        $markoProfil = FarmerProfile::create([
            'user_id'     => $marko->id,
            'farm_name'   => 'Organsko imanje Petrović',
            'description' => 'Uzgajamo organsko povrće bez pesticida na 3 hektara u okolici Prnjavora. Svježe ubrano svako jutro.',
            'city'        => 'prnjavor',
            'address'     => null,
            'is_active'   => true,
        ]);

        $this->saveAvatar($marko->id, $markoProfil->id, 12);

        Product::create([
            'user_id'    => $marko->id,
            'category'   => 'povrce',
            'name'       => 'Paradajz organski',
            'description'=> 'Sočni organsko uzgojeni paradajz, sorti "beef" i "cherry". Bez hemije.',
            'price'      => 2.50,
            'price_unit' => 'kg',
            'fresh_until'=> now()->addHours(24),
            'is_active'  => true,
        ]);

        Product::create([
            'user_id'    => $marko->id,
            'category'   => 'povrce',
            'name'       => 'Paprika babura',
            'description'=> 'Crvena i žuta babura, odlična za punjenje i salate.',
            'price'      => 1.80,
            'price_unit' => 'kg',
            'fresh_until'=> now()->addHours(24),
            'is_active'  => true,
        ]);

        Product::create([
            'user_id'    => $marko->id,
            'category'   => 'povrce',
            'name'       => 'Crni luk',
            'description'=> 'Domaći crni luk, suho čuvan, traje do 6 mjeseci.',
            'price'      => 0.90,
            'price_unit' => 'kg',
            'fresh_until'=> null,
            'is_active'  => true,
        ]);

        Review::create(['farmer_id' => $markoProfil->id, 'reviewer_name' => 'Jovanka S.',   'body' => 'Odlično povrće, uvijek svježe. Redovno kupujem paradajz i papriku. Preporučujem svima!',        'rating' => 5, 'ip_hash' => hash('sha256', '1.1.1.1')]);
        Review::create(['farmer_id' => $markoProfil->id, 'reviewer_name' => 'Dragan M.',    'body' => 'Crni luk odlično čuvan, traje cijelu zimu. Poštena cijena, domaći kvalitet.',                   'rating' => 5, 'ip_hash' => hash('sha256', '1.1.1.2')]);
        Review::create(['farmer_id' => $markoProfil->id, 'reviewer_name' => 'Milena R.',    'body' => 'Uvijek ljubazni, dostava brza. Jedini prigovor — ponekad nema svega na stanju.',                  'rating' => 4, 'ip_hash' => hash('sha256', '1.1.1.3')]);
        Review::create(['farmer_id' => $markoProfil->id, 'reviewer_name' => 'Zoran P.',     'body' => 'Paradajz "beef" je ogromne veličine i odličnog ukusa. Pravi domaći.',                             'rating' => 5, 'ip_hash' => hash('sha256', '1.1.1.4')]);

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

        $anaProfil = FarmerProfile::create([
            'user_id'     => $ana->id,
            'farm_name'   => 'Mljekara Kovačević',
            'description' => 'Porodična farma sa 12 krava, svakog jutra svježe mlijeko i domaći sir. Tradicija od 1985. godine.',
            'city'        => 'prnjavor',
            'address'     => 'Konjuhovci',
            'is_active'   => true,
        ]);

        $this->saveAvatar($ana->id, $anaProfil->id, 47);

        Product::create([
            'user_id'    => $ana->id,
            'category'   => 'mlijeko',
            'name'       => 'Svježe kravlje mlijeko',
            'description'=> 'Pasterizirano mlijeko sa naše farme, punjeno u staklenke od 1L. Preuzimanje svako jutro do 9h.',
            'price'      => 1.50,
            'price_unit' => 'l',
            'fresh_until'=> now()->addHours(24),
            'is_active'  => true,
        ]);

        Product::create([
            'user_id'    => $ana->id,
            'category'   => 'mlijeko',
            'name'       => 'Domaći bijeli sir',
            'description'=> 'Mekani bijeli sir u salamuri, pravi domaći ukus.',
            'price'      => 8.00,
            'price_unit' => 'kg',
            'fresh_until'=> null,
            'is_active'  => true,
        ]);

        Review::create(['farmer_id' => $anaProfil->id, 'reviewer_name' => 'Bojan K.',      'body' => 'Najbolje mlijeko u okolici, svakog jutra svježe. Djeca ne piju ništa drugo.',                    'rating' => 5, 'ip_hash' => hash('sha256', '2.1.1.1')]);
        Review::create(['farmer_id' => $anaProfil->id, 'reviewer_name' => 'Snježana T.',   'body' => 'Domaći sir kao iz djetinjstva. Salamura savršena, nije preslano. Hvala Ana!',                     'rating' => 5, 'ip_hash' => hash('sha256', '2.1.1.2')]);
        Review::create(['farmer_id' => $anaProfil->id, 'reviewer_name' => 'Miloš A.',      'body' => 'Mlijeko izvrsno, ali ponekad nema na stanju rano ujutro jer se brzo rasprodaje.',                  'rating' => 4, 'ip_hash' => hash('sha256', '2.1.1.3')]);
        Review::create(['farmer_id' => $anaProfil->id, 'reviewer_name' => 'Rada V.',       'body' => 'Kupujem od Ane već 3 godine. Nikad razočarana, kvalitet uvijek isti.',                             'rating' => 5, 'ip_hash' => hash('sha256', '2.1.1.4')]);

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

        $draganProfil = FarmerProfile::create([
            'user_id'     => $dragan->id,
            'farm_name'   => 'Eko gazdinstvo Vujić',
            'description' => 'Pčelarstvo, živinarstvo i povrtlarstvo. Sve što vam treba sa jednog mjesta — med, jaja i krompir.',
            'city'        => 'prnjavor',
            'address'     => 'Lišnja',
            'is_active'   => true,
        ]);

        $this->saveAvatar($dragan->id, $draganProfil->id, 15);

        Product::create([
            'user_id'    => $dragan->id,
            'category'   => 'med',
            'name'       => 'Livadski med',
            'description'=> 'Čisti livadski med sa planine Trebave. Bez dodavanja šećera, 100% prirodan.',
            'price'      => 15.00,
            'price_unit' => 'kg',
            'fresh_until'=> null,
            'is_active'  => true,
        ]);

        Product::create([
            'user_id'    => $dragan->id,
            'category'   => 'jaja',
            'name'       => 'Svježa seoska jaja',
            'description'=> 'Jaja slobodno pasenih kokoši, hranjenih prirodnom hranom. Žumanjak tamno narandžaste boje.',
            'price'      => 0.30,
            'price_unit' => 'kom',
            'fresh_until'=> now()->addHours(24),
            'is_active'  => true,
        ]);

        Product::create([
            'user_id'    => $dragan->id,
            'category'   => 'povrce',
            'name'       => 'Krompir bijeli',
            'description'=> 'Domaći bijeli krompir, sorta "Desiree", bez prskanja.',
            'price'      => 0.70,
            'price_unit' => 'kg',
            'fresh_until'=> null,
            'is_active'  => true,
        ]);

        Review::create(['farmer_id' => $draganProfil->id, 'reviewer_name' => 'Zoran B.',    'body' => 'Med je pravi, kristalizira kako treba. Kupio sam 3kg i ne žalim ni dinara.',                    'rating' => 5, 'ip_hash' => hash('sha256', '3.1.1.1')]);
        Review::create(['farmer_id' => $draganProfil->id, 'reviewer_name' => 'Lidija P.',   'body' => 'Jaja su stvarno drugačija od komercijalnih — žumanjak tamno narandžast i gust.',                 'rating' => 5, 'ip_hash' => hash('sha256', '3.1.1.2')]);
        Review::create(['farmer_id' => $draganProfil->id, 'reviewer_name' => 'Radoslav N.', 'body' => 'Krompir odličan, bez prskanja. Preporučujem gazdinstvo Vujić cijelom selu.',                      'rating' => 5, 'ip_hash' => hash('sha256', '3.1.1.3')]);
        Review::create(['farmer_id' => $draganProfil->id, 'reviewer_name' => 'Vesna O.',    'body' => 'Dragan je uvijek tu kad zatreba. Brz odgovor na Viber, isporuka isti dan.',                       'rating' => 4, 'ip_hash' => hash('sha256', '3.1.1.4')]);
    }

    private function saveAvatar(int $userId, int $profileId, int $imgNum): void
    {
        try {
            $response = Http::withoutVerifying()->timeout(10)->get("https://i.pravatar.cc/300?img={$imgNum}");
            if ($response->successful()) {
                $path = "farmers/{$userId}/avatar.jpg";
                Storage::disk()->put($path, $response->body());
                Photo::create([
                    'photoable_id'   => $profileId,
                    'photoable_type' => FarmerProfile::class,
                    'path'           => $path,
                    'position'       => 0,
                ]);
            }
        } catch (\Throwable) {
            // Network unavailable — skip avatar, seeder continues
        }
    }
}
