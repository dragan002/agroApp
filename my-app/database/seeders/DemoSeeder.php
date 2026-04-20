<?php

namespace Database\Seeders;

use App\Models\FarmerProfile;
use App\Models\Product;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DemoSeeder extends Seeder
{
    public function run(): void
    {
        // Farmer 4 — Milica Đurić, voće, Vijačani (Prnjavor)
        $milica = User::create([
            'name'            => 'Milica Đurić',
            'email'           => 'milica.djuric@example.com',
            'password'        => Hash::make('password'),
            'role'            => 'farmer',
            'phone'           => '+38765401502',
            'viber'           => '+38765401502',
            'whatsapp'        => '+38765401502',
            'onboarding_step' => null,
        ]);

        FarmerProfile::create([
            'user_id'     => $milica->id,
            'farm_name'   => 'Voćnjak Đurić',
            'description' => 'Porodični voćnjak od 4 hektara u Vijačanima. Uzgajamo jabuke, šljive i kruške od djeda i babe. Bez prskanja hemijom — samo prirodna zaštita. Berba od avgusta do oktobra, a suhe šljive i džemovi dostupni tokom cijele godine.',
            'city'        => 'prnjavor',
            'address'     => 'Vijačani bb',
            'is_active'   => true,
        ]);

        Product::create([
            'user_id'     => $milica->id,
            'category'    => 'voce',
            'name'        => 'Jabuke "Ajdared"',
            'description' => 'Krupne crvene jabuke, slatko-kiselog ukusa. Čuvaju se do februara. Prodajemo u kutijama od 10 kg.',
            'price'       => 1.20,
            'price_unit'  => 'kg',
            'fresh_today' => true,
            'is_active'   => true,
        ]);

        Product::create([
            'user_id'     => $milica->id,
            'category'    => 'voce',
            'name'        => 'Suhe šljive domaće',
            'description' => 'Prirodno sušene šljive bez konzervansa, sorta "Požegača". Odlične za kompot i kolače.',
            'price'       => 4.50,
            'price_unit'  => 'kg',
            'fresh_today' => false,
            'is_active'   => true,
        ]);

        Product::create([
            'user_id'     => $milica->id,
            'category'    => 'zimnica',
            'name'        => 'Džem od šljive',
            'description' => 'Domaći džem kuhan bez konzervansa, tegla 400g. Samo šljiva i malo šećera.',
            'price'       => 3.00,
            'price_unit'  => 'kom',
            'fresh_today' => false,
            'is_active'   => true,
        ]);

        // Farmer 5 — Nikola Simić, meso, Prnjavor
        $nikola = User::create([
            'name'            => 'Nikola Simić',
            'email'           => 'nikola.simic@example.com',
            'password'        => Hash::make('password'),
            'role'            => 'farmer',
            'phone'           => '+38763512600',
            'viber'           => '+38763512600',
            'whatsapp'        => null,
            'onboarding_step' => null,
        ]);

        FarmerProfile::create([
            'user_id'     => $nikola->id,
            'farm_name'   => 'Farma Simić — ovčarstvo',
            'description' => 'Uzgajamo ovce i svinje na prirodnoj ispaši u okolici Prnjavora. Klanje po narudžbi, dostava na kućnu adresu u Prnjavoru. Jagnjetina dostupna od marta, svinjetina tokom cijele godine.',
            'city'        => 'prnjavor',
            'address'     => 'Štrpci 14',
            'is_active'   => true,
        ]);

        Product::create([
            'user_id'     => $nikola->id,
            'category'    => 'meso',
            'name'        => 'Jagnjetina svježa',
            'description' => 'Mlado janje, slobodna ispaša. Prodajemo cijelo ili pola jagnjeta po dogovoru. Težina 10–14 kg.',
            'price'       => 12.00,
            'price_unit'  => 'kg',
            'fresh_today' => false,
            'is_active'   => true,
        ]);

        Product::create([
            'user_id'     => $nikola->id,
            'category'    => 'meso',
            'name'        => 'Domaća slanina',
            'description' => 'Dimljena slanina od domaće svinje, sušena 3 mjeseca. Narezana ili cijeli komad.',
            'price'       => 9.00,
            'price_unit'  => 'kg',
            'fresh_today' => false,
            'is_active'   => true,
        ]);

        Product::create([
            'user_id'     => $nikola->id,
            'category'    => 'meso',
            'name'        => 'Domaća kobasica',
            'description' => 'Svinjska kobasica sa domaćim začinima, dimljena hladnim dimom. Kilogram — 6 komada.',
            'price'       => 11.00,
            'price_unit'  => 'kg',
            'fresh_today' => false,
            'is_active'   => true,
        ]);

        // Farmer 6 — Zdravko Marković, rakija + zimnica, Derventa
        $zdravko = User::create([
            'name'            => 'Zdravko Marković',
            'email'           => 'zdravko.markovic@example.com',
            'password'        => Hash::make('password'),
            'role'            => 'farmer',
            'phone'           => '+38766620100',
            'viber'           => '+38766620100',
            'whatsapp'        => '+38766620100',
            'onboarding_step' => null,
        ]);

        FarmerProfile::create([
            'user_id'     => $zdravko->id,
            'farm_name'   => 'Gazdinstvo Marković',
            'description' => 'Trećа generacija rakijdžija iz Dervente. Šljiva "Požegača" sa vlastitog voćnjaka, destilacija u bakrenjem kotlu. Pored rakije, žena sprema zimnicom — ajvar, kiseli kupus, lečo. Sve što treba za zimu.',
            'city'        => 'derventa',
            'address'     => 'Bosanski Kobaš bb',
            'is_active'   => true,
        ]);

        Product::create([
            'user_id'     => $zdravko->id,
            'category'    => 'rakija',
            'name'        => 'Šljivovica 3 godine',
            'description' => 'Odležala šljivovica u hrastovoj bačvi, 42% alkohola. Flaša 1L, nema etikete — pravi domaći.',
            'price'       => 20.00,
            'price_unit'  => 'l',
            'fresh_today' => false,
            'is_active'   => true,
        ]);

        Product::create([
            'user_id'     => $zdravko->id,
            'category'    => 'zimnica',
            'name'        => 'Domaći ajvar',
            'description' => 'Pečena paprika, paprena sorta "roga". Kuhano 4 sata na laganoj vatri bez konzervansa. Tegla 720ml.',
            'price'       => 6.50,
            'price_unit'  => 'kom',
            'fresh_today' => false,
            'is_active'   => true,
        ]);

        Product::create([
            'user_id'     => $zdravko->id,
            'category'    => 'zimnica',
            'name'        => 'Kiseli kupus cijela glavica',
            'description' => 'Kiseljeno u buretu, domaća sorta. Prodajemo na komad (1,5–2 kg po glavici) ili u kanisteru od 10 kg.',
            'price'       => 1.20,
            'price_unit'  => 'kg',
            'fresh_today' => false,
            'is_active'   => true,
        ]);

        // Farmer 7 — Vesna Ilić, žitarice i brašno, Prnjavor
        $vesna = User::create([
            'name'            => 'Vesna Ilić',
            'email'           => 'vesna.ilic@example.com',
            'password'        => Hash::make('password'),
            'role'            => 'farmer',
            'phone'           => '+38765730200',
            'viber'           => null,
            'whatsapp'        => '+38765730200',
            'onboarding_step' => null,
        ]);

        FarmerProfile::create([
            'user_id'     => $vesna->id,
            'farm_name'   => 'Mlin i polje Ilić',
            'description' => 'Uzgajamo pšenicu, kukuruz i ječam na 8 hektara kod Prnjavora. Imamo vlastiti mali mlin — meljemo kukuruzno i pšenično brašno za domaćinstva. Brašno bez aditiva, pravo krupno mljeveno.',
            'city'        => 'prnjavor',
            'address'     => 'Lupljanica bb',
            'is_active'   => true,
        ]);

        Product::create([
            'user_id'     => $vesna->id,
            'category'    => 'zitarice',
            'name'        => 'Kukuruzno brašno krupno',
            'description' => 'Mljveno od domaćeg žutog kukuruza, pravo za proju i polenta. Vrećica 5 kg.',
            'price'       => 2.50,
            'price_unit'  => 'kg',
            'fresh_today' => false,
            'is_active'   => true,
        ]);

        Product::create([
            'user_id'     => $vesna->id,
            'category'    => 'zitarice',
            'name'        => 'Pšenično brašno T-500',
            'description' => 'Bijelo pšenično brašno sa vlastite pšenice, mljeveno u lokalnom mlinu. Vrećica 5 kg.',
            'price'       => 3.00,
            'price_unit'  => 'kg',
            'fresh_today' => false,
            'is_active'   => true,
        ]);

        Product::create([
            'user_id'     => $vesna->id,
            'category'    => 'zitarice',
            'name'        => 'Ječam za stočnu hranu',
            'description' => 'Čist ječam za ishranu stoke i peradi, u džakovima od 25 kg.',
            'price'       => 0.55,
            'price_unit'  => 'kg',
            'fresh_today' => false,
            'is_active'   => true,
        ]);

        // Farmer 8 — Slobodan Tešić, med + voće, Kotor Varoš
        $slobodan = User::create([
            'name'            => 'Slobodan Tešić',
            'email'           => 'slobodan.tesic@example.com',
            'password'        => Hash::make('password'),
            'role'            => 'farmer',
            'phone'           => '+38763840300',
            'viber'           => '+38763840300',
            'whatsapp'        => '+38763840300',
            'onboarding_step' => null,
        ]);

        FarmerProfile::create([
            'user_id'     => $slobodan->id,
            'farm_name'   => 'Pčelarstvo i voćarstvo Tešić',
            'description' => 'Imam 60 košnica na planini Vlašić i mali voćnjak ispod. Med skupljam dva puta godišnje — proljetni bagremov i ljetni livadski. Sve se prodaje direktno, bez preprodavca. Dostava na području Kotor Varoši i Prnjavora.',
            'city'        => 'kotor_varos',
            'address'     => 'Garići bb',
            'is_active'   => true,
        ]);

        Product::create([
            'user_id'     => $slobodan->id,
            'category'    => 'med',
            'name'        => 'Bagremov med',
            'description' => 'Proljetni bagremov med, svijetložute boje, blag i aromatičan. Tegla 1 kg ili 0,5 kg.',
            'price'       => 18.00,
            'price_unit'  => 'kg',
            'fresh_today' => false,
            'is_active'   => true,
        ]);

        Product::create([
            'user_id'     => $slobodan->id,
            'category'    => 'med',
            'name'        => 'Livadski med sa Vlašića',
            'description' => 'Tamni ljetni med bogat polenima planinskog cvijeća. Kristalizira brzo — znak čistoće.',
            'price'       => 16.00,
            'price_unit'  => 'kg',
            'fresh_today' => false,
            'is_active'   => true,
        ]);

        Product::create([
            'user_id'     => $slobodan->id,
            'category'    => 'voce',
            'name'        => 'Kruške "Viljamovka"',
            'description' => 'Sočne Viljamovke, zrele u augustu. Prodajemo na licu mjesta ili dostavljamo u Prnjavor petkom.',
            'price'       => 1.50,
            'price_unit'  => 'kg',
            'fresh_today' => false,
            'is_active'   => true,
        ]);
    }
}
