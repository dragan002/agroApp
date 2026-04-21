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

        $milicaProfil = FarmerProfile::create([
            'user_id'     => $milica->id,
            'farm_name'   => 'Voćnjak Đurić',
            'description' => 'Porodični voćnjak od 4 hektara u Vijačanima. Uzgajamo jabuke, šljive i kruške od djeda i babe. Bez prskanja hemijom — samo prirodna zaštita. Berba od avgusta do oktobra, a suhe šljive i džemovi dostupni tokom cijele godine.',
            'city'        => 'prnjavor',
            'address'     => 'Vijačani bb',
            'is_active'   => true,
        ]);

        $this->saveAvatar($milica->id, $milicaProfil->id, 44);

        Product::create([
            'user_id'     => $milica->id,
            'category'    => 'voce',
            'name'        => 'Jabuke "Ajdared"',
            'description' => 'Krupne crvene jabuke, slatko-kiselog ukusa. Čuvaju se do februara. Prodajemo u kutijama od 10 kg.',
            'price'       => 1.20,
            'price_unit'  => 'kg',
            'fresh_until' => now()->addHours(24),
            'is_active'   => true,
        ]);

        Product::create([
            'user_id'     => $milica->id,
            'category'    => 'voce',
            'name'        => 'Suhe šljive domaće',
            'description' => 'Prirodno sušene šljive bez konzervansa, sorta "Požegača". Odlične za kompot i kolače.',
            'price'       => 4.50,
            'price_unit'  => 'kg',
            'fresh_until' => null,
            'is_active'   => true,
        ]);

        Product::create([
            'user_id'     => $milica->id,
            'category'    => 'zimnica',
            'name'        => 'Džem od šljive',
            'description' => 'Domaći džem kuhan bez konzervansa, tegla 400g. Samo šljiva i malo šećera.',
            'price'       => 3.00,
            'price_unit'  => 'kom',
            'fresh_until' => null,
            'is_active'   => true,
        ]);

        Review::create(['farmer_id' => $milicaProfil->id, 'reviewer_name' => 'Anđela M.',   'body' => 'Jabuke "Ajdared" su prekrasne — krupne, hrskave, slatke. Kutija od 10kg nestane za tjedan.',   'rating' => 5, 'ip_hash' => hash('sha256', '4.1.1.1')]);
        Review::create(['farmer_id' => $milicaProfil->id, 'reviewer_name' => 'Predrag S.',  'body' => 'Džem od šljive je savršen za palačinke. Kupio sam 6 tegli i već polovina otišla.',              'rating' => 5, 'ip_hash' => hash('sha256', '4.1.1.2')]);
        Review::create(['farmer_id' => $milicaProfil->id, 'reviewer_name' => 'Gordana K.',  'body' => 'Suhe šljive su odlične za kompot. Naručila sam 2kg, isporuka brza i uredna.',                    'rating' => 5, 'ip_hash' => hash('sha256', '4.1.1.3')]);
        Review::create(['farmer_id' => $milicaProfil->id, 'reviewer_name' => 'Tomislav B.', 'body' => 'Domaći kvalitet, bez kemije. Jedini minus — ponekad rasprodato u sezoni.',                        'rating' => 4, 'ip_hash' => hash('sha256', '4.1.1.4')]);

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

        $nikolaProfil = FarmerProfile::create([
            'user_id'     => $nikola->id,
            'farm_name'   => 'Farma Simić — ovčarstvo',
            'description' => 'Uzgajamo ovce i svinje na prirodnoj ispaši u okolici Prnjavora. Klanje po narudžbi, dostava na kućnu adresu u Prnjavoru. Jagnjetina dostupna od marta, svinjetina tokom cijele godine.',
            'city'        => 'prnjavor',
            'address'     => 'Štrpci 14',
            'is_active'   => true,
        ]);

        $this->saveAvatar($nikola->id, $nikolaProfil->id, 22);

        Product::create([
            'user_id'     => $nikola->id,
            'category'    => 'meso',
            'name'        => 'Jagnjetina svježa',
            'description' => 'Mlado janje, slobodna ispaša. Prodajemo cijelo ili pola jagnjeta po dogovoru. Težina 10–14 kg.',
            'price'       => 12.00,
            'price_unit'  => 'kg',
            'fresh_until' => null,
            'is_active'   => true,
        ]);

        Product::create([
            'user_id'     => $nikola->id,
            'category'    => 'meso',
            'name'        => 'Domaća slanina',
            'description' => 'Dimljena slanina od domaće svinje, sušena 3 mjeseca. Narezana ili cijeli komad.',
            'price'       => 9.00,
            'price_unit'  => 'kg',
            'fresh_until' => null,
            'is_active'   => true,
        ]);

        Product::create([
            'user_id'     => $nikola->id,
            'category'    => 'meso',
            'name'        => 'Domaća kobasica',
            'description' => 'Svinjska kobasica sa domaćim začinima, dimljena hladnim dimom. Kilogram — 6 komada.',
            'price'       => 11.00,
            'price_unit'  => 'kg',
            'fresh_until' => null,
            'is_active'   => true,
        ]);

        Review::create(['farmer_id' => $nikolaProfil->id, 'reviewer_name' => 'Petar J.',    'body' => 'Jagnjetina za Đurđevdan — savršena. Mekano meso, prirodan miris. Ovo je pravo domaće.',         'rating' => 5, 'ip_hash' => hash('sha256', '5.1.1.1')]);
        Review::create(['farmer_id' => $nikolaProfil->id, 'reviewer_name' => 'Slavica M.',  'body' => 'Kobasice su fenomenalne! Dim i začin su odmjereni, nije preslano.',                               'rating' => 5, 'ip_hash' => hash('sha256', '5.1.1.2')]);
        Review::create(['farmer_id' => $nikolaProfil->id, 'reviewer_name' => 'Novak D.',    'body' => 'Slanina odlično dimljena. Naručio sam dva puta i oba puta zadovoljan.',                            'rating' => 5, 'ip_hash' => hash('sha256', '5.1.1.3')]);
        Review::create(['farmer_id' => $nikolaProfil->id, 'reviewer_name' => 'Nataša R.',   'body' => 'Nikola je pouzdan i tačan. Jedina napomena — treba rezervirati janje unaprijed.',                  'rating' => 4, 'ip_hash' => hash('sha256', '5.1.1.4')]);

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

        $zdravkoProfil = FarmerProfile::create([
            'user_id'     => $zdravko->id,
            'farm_name'   => 'Gazdinstvo Marković',
            'description' => 'Treća generacija rakijdžija iz Dervente. Šljiva "Požegača" sa vlastitog voćnjaka, destilacija u bakrenom kotlu. Pored rakije, žena sprema zimnicom — ajvar, kiseli kupus, lečo. Sve što treba za zimu.',
            'city'        => 'derventa',
            'address'     => 'Bosanski Kobaš bb',
            'is_active'   => true,
        ]);

        $this->saveAvatar($zdravko->id, $zdravkoProfil->id, 33);

        Product::create([
            'user_id'     => $zdravko->id,
            'category'    => 'rakija',
            'name'        => 'Šljivovica 3 godine',
            'description' => 'Odležala šljivovica u hrastovoj bačvi, 42% alkohola. Flaša 1L, nema etikete — pravi domaći.',
            'price'       => 20.00,
            'price_unit'  => 'l',
            'fresh_until' => null,
            'is_active'   => true,
        ]);

        Product::create([
            'user_id'     => $zdravko->id,
            'category'    => 'zimnica',
            'name'        => 'Domaći ajvar',
            'description' => 'Pečena paprika, paprena sorta "roga". Kuhano 4 sata na laganoj vatri bez konzervansa. Tegla 720ml.',
            'price'       => 6.50,
            'price_unit'  => 'kom',
            'fresh_until' => null,
            'is_active'   => true,
        ]);

        Product::create([
            'user_id'     => $zdravko->id,
            'category'    => 'zimnica',
            'name'        => 'Kiseli kupus cijela glavica',
            'description' => 'Kiseljeno u buretu, domaća sorta. Prodajemo na komad (1,5–2 kg po glavici) ili u kanisteru od 10 kg.',
            'price'       => 1.20,
            'price_unit'  => 'kg',
            'fresh_until' => null,
            'is_active'   => true,
        ]);

        Review::create(['farmer_id' => $zdravkoProfil->id, 'reviewer_name' => 'Mirko S.',   'body' => 'Šljivovica iz bakra — pravi stari recept. Tri godine čekanja je vrijedno. Ponesi u posjetu.',    'rating' => 5, 'ip_hash' => hash('sha256', '6.1.1.1')]);
        Review::create(['farmer_id' => $zdravkoProfil->id, 'reviewer_name' => 'Dijana B.',  'body' => 'Ajvar je ukusan, gust, pun okusa paprike. Kupila sam 6 tegli za zimu.',                           'rating' => 5, 'ip_hash' => hash('sha256', '6.1.1.2')]);
        Review::create(['farmer_id' => $zdravkoProfil->id, 'reviewer_name' => 'Borislav T.','body' => 'Kiseli kupus odličan za sarmu. Kiseo kako treba, nije premekan.',                                  'rating' => 5, 'ip_hash' => hash('sha256', '6.1.1.3')]);
        Review::create(['farmer_id' => $zdravkoProfil->id, 'reviewer_name' => 'Ljiljana M.','body' => 'Zdravko je gostoljubiv domaćin. Može se kušati prije kupovine, to mnogo znači.',                  'rating' => 5, 'ip_hash' => hash('sha256', '6.1.1.4')]);

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

        $vesnaProfil = FarmerProfile::create([
            'user_id'     => $vesna->id,
            'farm_name'   => 'Mlin i polje Ilić',
            'description' => 'Uzgajamo pšenicu, kukuruz i ječam na 8 hektara kod Prnjavora. Imamo vlastiti mali mlin — meljemo kukuruzno i pšenično brašno za domaćinstva. Brašno bez aditiva, pravo krupno mljeveno.',
            'city'        => 'prnjavor',
            'address'     => 'Lupljanica bb',
            'is_active'   => true,
        ]);

        $this->saveAvatar($vesna->id, $vesnaProfil->id, 49);

        Product::create([
            'user_id'     => $vesna->id,
            'category'    => 'zitarice',
            'name'        => 'Kukuruzno brašno krupno',
            'description' => 'Mljeveno od domaćeg žutog kukuruza, pravo za proju i polenta. Vrećica 5 kg.',
            'price'       => 2.50,
            'price_unit'  => 'kg',
            'fresh_until' => null,
            'is_active'   => true,
        ]);

        Product::create([
            'user_id'     => $vesna->id,
            'category'    => 'zitarice',
            'name'        => 'Pšenično brašno T-500',
            'description' => 'Bijelo pšenično brašno sa vlastite pšenice, mljeveno u lokalnom mlinu. Vrećica 5 kg.',
            'price'       => 3.00,
            'price_unit'  => 'kg',
            'fresh_until' => null,
            'is_active'   => true,
        ]);

        Product::create([
            'user_id'     => $vesna->id,
            'category'    => 'zitarice',
            'name'        => 'Ječam za stočnu hranu',
            'description' => 'Čist ječam za ishranu stoke i peradi, u džakovima od 25 kg.',
            'price'       => 0.55,
            'price_unit'  => 'kg',
            'fresh_until' => null,
            'is_active'   => true,
        ]);

        Review::create(['farmer_id' => $vesnaProfil->id, 'reviewer_name' => 'Mira J.',      'body' => 'Kukuruzno brašno iz Vesninog mlina je pravo — proja ispade nevjerovatna, rahla i zlatna.',       'rating' => 5, 'ip_hash' => hash('sha256', '7.1.1.1')]);
        Review::create(['farmer_id' => $vesnaProfil->id, 'reviewer_name' => 'Đorđe N.',     'body' => 'Pšenično brašno kvalitetno, hljeb dobro naraste. Nema onih aditiva iz prodavnice.',               'rating' => 5, 'ip_hash' => hash('sha256', '7.1.1.2')]);
        Review::create(['farmer_id' => $vesnaProfil->id, 'reviewer_name' => 'Biljana K.',   'body' => 'Kupujem brašno redovno. Vesna je uvijek uredna i brašno je dobro zapakovano.',                    'rating' => 4, 'ip_hash' => hash('sha256', '7.1.1.3')]);

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

        $slobodanProfil = FarmerProfile::create([
            'user_id'     => $slobodan->id,
            'farm_name'   => 'Pčelarstvo i voćarstvo Tešić',
            'description' => 'Imam 60 košnica na planini Vlašić i mali voćnjak ispod. Med skupljam dva puta godišnje — proljetni bagremov i ljetni livadski. Sve se prodaje direktno, bez preprodavca. Dostava na području Kotor Varoši i Prnjavora.',
            'city'        => 'kotor_varos',
            'address'     => 'Garići bb',
            'is_active'   => true,
        ]);

        $this->saveAvatar($slobodan->id, $slobodanProfil->id, 65);

        Product::create([
            'user_id'     => $slobodan->id,
            'category'    => 'med',
            'name'        => 'Bagremov med',
            'description' => 'Proljetni bagremov med, svijetložute boje, blag i aromatičan. Tegla 1 kg ili 0,5 kg.',
            'price'       => 18.00,
            'price_unit'  => 'kg',
            'fresh_until' => null,
            'is_active'   => true,
        ]);

        Product::create([
            'user_id'     => $slobodan->id,
            'category'    => 'med',
            'name'        => 'Livadski med sa Vlašića',
            'description' => 'Tamni ljetni med bogat polenima planinskog cvijeća. Kristalizira brzo — znak čistoće.',
            'price'       => 16.00,
            'price_unit'  => 'kg',
            'fresh_until' => null,
            'is_active'   => true,
        ]);

        Product::create([
            'user_id'     => $slobodan->id,
            'category'    => 'voce',
            'name'        => 'Kruške "Viljamovka"',
            'description' => 'Sočne Viljamovke, zrele u augustu. Prodajemo na licu mjesta ili dostavljamo u Prnjavor petkom.',
            'price'       => 1.50,
            'price_unit'  => 'kg',
            'fresh_until' => null,
            'is_active'   => true,
        ]);

        Review::create(['farmer_id' => $slobodanProfil->id, 'reviewer_name' => 'Renata P.',  'body' => 'Bagremov med sa Vlašića je poseban — blag, mirisav, djeca ga obožavaju. Svaka preporuka.',      'rating' => 5, 'ip_hash' => hash('sha256', '8.1.1.1')]);
        Review::create(['farmer_id' => $slobodanProfil->id, 'reviewer_name' => 'Saša V.',    'body' => 'Livadski med kristalizira kako treba — to je dokaz da nije prerađivan. Kupio sam 2kg.',           'rating' => 5, 'ip_hash' => hash('sha256', '8.1.1.2')]);
        Review::create(['farmer_id' => $slobodanProfil->id, 'reviewer_name' => 'Tanja M.',   'body' => 'Slobodan je pčelar sa strašću. Sve mi je objasnio o medu, kristalizaciji i čuvanju.',             'rating' => 5, 'ip_hash' => hash('sha256', '8.1.1.3')]);
        Review::create(['farmer_id' => $slobodanProfil->id, 'reviewer_name' => 'Dragan L.',  'body' => 'Kruške "Viljamovka" su sočne i mirisave. Dostava petkom u Prnjavor je pogodna.',                  'rating' => 4, 'ip_hash' => hash('sha256', '8.1.1.4')]);
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
