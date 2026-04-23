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
        // Farmer 1 — Marko Petrović, organsko povrće, Prnjavor
        $marko = User::create([
            'name'            => 'Marko Petrović',
            'email'           => 'marko@example.com',
            'password'        => Hash::make('password'),
            'role'            => 'farmer',
            'phone'           => '+38765100200',
            'viber'           => '+38765100200',
            'whatsapp'        => '+38765100200',
            'onboarding_step' => null,
        ]);

        $markoProfil = FarmerProfile::create([
            'user_id'     => $marko->id,
            'farm_name'   => 'Organsko imanje Petrović',
            'description' => 'Organsko imanje na 3 hektara plodne zemlje u Vijačanima, nadomak Prnjavora. Porodica Petrović uzgaja povrće bez pesticida i sintetičkih đubriva od 2008. godine. Koristimo samo stare, domaće sorte — ono što su naši djedovi sadili. Svakodnevna berba garantuje da na vaš sto stiže isključivo najsvježije povrće. Sertifikat za organsku proizvodnju imamo od 2015. Dostavljamo u Prnjavor utorkom, četvrtkom i subotom.',
            'city'        => 'prnjavor',
            'address'     => 'Vijačani bb',
            'is_active'   => true,
        ]);

        $this->savePhoto($marko->id, $markoProfil->id, 'farmer,vegetables', 101, 0);
        $this->savePhoto($marko->id, $markoProfil->id, 'organic,farm,field', 102, 1, 800, 600);

        $p = Product::create([
            'user_id'     => $marko->id,
            'category'    => 'povrce',
            'name'        => 'Paradajz organski "Volovski"',
            'description' => 'Krupni volovski paradajz iz organskog uzgoja, bere se svaki dan ujutro. Mesnati, slatki, bez voštanog premaza. Savršen za salatu, punjenje i zimnice. Certificiran kao organski. Minimalna narudžba 2 kg.',
            'price'       => 2.80,
            'price_unit'  => 'kg',
            'fresh_until' => now()->addHours(24),
            'is_active'   => true,
        ]);
        $this->saveProductPhoto($marko->id, $p->id, 'tomato,organic', 201);

        $p = Product::create([
            'user_id'     => $marko->id,
            'category'    => 'povrce',
            'name'        => 'Babura paprika (crvena i žuta)',
            'description' => 'Mesnata babura paprika u crvenoj i žutoj boji, uzgojena bez pesticida. Odlična za punjenje, salate i pečenje na žaru. Prodajemo u mješanim kutijama od 3 kg. Berba svaki dan u sezoni jula i avgusta.',
            'price'       => 2.00,
            'price_unit'  => 'kg',
            'fresh_until' => now()->addHours(24),
            'is_active'   => true,
        ]);
        $this->saveProductPhoto($marko->id, $p->id, 'pepper,vegetable', 202);

        $p = Product::create([
            'user_id'     => $marko->id,
            'category'    => 'povrce',
            'name'        => 'Krastavac kornišon',
            'description' => 'Sitni kornišoni, pravo za kiseljenje i svježe salate. Berba svakodnevno u julu i avgustu — uvijek hrskavi i sočni. Idealni za zimske tegle ili kao prilog uz meso. Dostupni u sezonskim kutijama od 5 kg.',
            'price'       => 1.50,
            'price_unit'  => 'kg',
            'fresh_until' => now()->addHours(24),
            'is_active'   => true,
        ]);
        $this->saveProductPhoto($marko->id, $p->id, 'cucumber,fresh', 203);

        $p = Product::create([
            'user_id'     => $marko->id,
            'category'    => 'povrce',
            'name'        => 'Bijeli luk domaći',
            'description' => 'Krupan bijeli luk stare domaće sorte. Suho čuvan u pletenim vijencima, traje 6 do 8 mjeseci. Oštar okus i snažan miris kakav se u prodavnici nikad ne može naći. Odličan i za sirov i za kuvanje.',
            'price'       => 4.00,
            'price_unit'  => 'kg',
            'fresh_until' => null,
            'is_active'   => true,
        ]);
        $this->saveProductPhoto($marko->id, $p->id, 'garlic', 204);

        $p = Product::create([
            'user_id'     => $marko->id,
            'category'    => 'povrce',
            'name'        => 'Crni luk',
            'description' => 'Domaći crni luk pakovan u suhe mreže od 5 kg. Ljuta sorta, idealna za kuvanje i prženje. Čuva se do 6 mjeseci na suhom i hladnom mjestu. Uzgojen bez pesticida.',
            'price'       => 0.90,
            'price_unit'  => 'kg',
            'fresh_until' => null,
            'is_active'   => true,
        ]);
        $this->saveProductPhoto($marko->id, $p->id, 'onion', 205);

        Review::create(['farmer_id' => $markoProfil->id, 'reviewer_name' => 'Jovanka S.',  'body' => 'Odlično organsko povrće — uvijek svježe i bez hemije. Redovno kupujem paradajz i papriku svake sedmice. Marko je pouzdan i uvijek dostavi na vrijeme.',          'rating' => 5, 'ip_hash' => hash('sha256', '1.1.1.1')]);
        Review::create(['farmer_id' => $markoProfil->id, 'reviewer_name' => 'Dragan M.',   'body' => 'Bijeli luk sa organskog imanja Petrović je najkvalitetniji koji sam probao. Pravi domaći ukus i poštena cijena za sertifikovani organski proizvod.',            'rating' => 5, 'ip_hash' => hash('sha256', '1.1.1.2')]);
        Review::create(['farmer_id' => $markoProfil->id, 'reviewer_name' => 'Milena R.',   'body' => 'Kornišoni savršeni za kiseljenje — hrskavi i ujednačene veličine. Jedini prigovor — u julu se brzo rasprodaju, treba naručiti ranije.',                         'rating' => 4, 'ip_hash' => hash('sha256', '1.1.1.3')]);
        Review::create(['farmer_id' => $markoProfil->id, 'reviewer_name' => 'Zoran P.',    'body' => 'Paradajz "Volovski" je ogromnih dimenzija i nevjerovatnog ukusa. Pravi domaći kakav odavno nisam jeo. Salata od ovog paradajza je poseban doživljaj.',           'rating' => 5, 'ip_hash' => hash('sha256', '1.1.1.4')]);
        Review::create(['farmer_id' => $markoProfil->id, 'reviewer_name' => 'Slavica J.',  'body' => 'Kupujem kod Marka već tri sezone zaredom. Nikad razočarana — povrće je uvijek svježe, urednog izgleda i dostava je tačna do minuta.',                           'rating' => 5, 'ip_hash' => hash('sha256', '1.1.1.5')]);

        // Farmer 2 — Ana Kovačević, mlijeko i mliječni, Prnjavor
        $ana = User::create([
            'name'            => 'Ana Kovačević',
            'email'           => 'ana@example.com',
            'password'        => Hash::make('password'),
            'role'            => 'farmer',
            'phone'           => '+38766200300',
            'viber'           => '+38766200300',
            'whatsapp'        => null,
            'onboarding_step' => null,
        ]);

        $anaProfil = FarmerProfile::create([
            'user_id'     => $ana->id,
            'farm_name'   => 'Mljekara Kovačević',
            'description' => 'Porodična farma sa 12 muznih krava simentalske rase u Konjuhovcima kod Prnjavora. Tradicija mljekarenja u porodici Kovačević traje od 1985. godine. Krave se hrane svježom travom i sijenom sa vlastitih livada — bez koncentrata i hormona rasta. Mlijeko se pasterizira u maloj kućnoj mljekari, sir i kajmak se prave ručno svaki dan. Preuzimanje na farmi svako jutro do 9 sati, ili dostava u Prnjavor.',
            'city'        => 'prnjavor',
            'address'     => 'Konjuhovci bb',
            'is_active'   => true,
        ]);

        $this->savePhoto($ana->id, $anaProfil->id, 'dairy,farm,woman', 103, 0);
        $this->savePhoto($ana->id, $anaProfil->id, 'dairy,barn,cows', 104, 1, 800, 600);

        $p = Product::create([
            'user_id'     => $ana->id,
            'category'    => 'mlijeko',
            'name'        => 'Svježe kravlje mlijeko',
            'description' => 'Pasterizirano punomasno mlijeko sa naše farme, punjeno u staklene flaše od 1L. Muzemo dva puta dnevno — ujutro i uvečer. Preuzimanje svako jutro do 9 sati ili dostava u Prnjavor. Rok trajanja 3 dana u hladnjaku.',
            'price'       => 1.50,
            'price_unit'  => 'l',
            'fresh_until' => now()->addHours(24),
            'is_active'   => true,
        ]);
        $this->saveProductPhoto($ana->id, $p->id, 'milk,dairy', 206);

        $p = Product::create([
            'user_id'     => $ana->id,
            'category'    => 'mlijeko',
            'name'        => 'Domaći bijeli sir u salamuri',
            'description' => 'Mekani bijeli sir u salamuri, pravi domaći ukus kakav se u prodavnici ne može kupiti. Pravi se svaki dan od punomasnog mlijeka naših krava. Prodajemo vakuumski pakovan u komadima od 0,5 kg ili u tegli. Odličan za salate i uz proju.',
            'price'       => 9.00,
            'price_unit'  => 'kg',
            'fresh_until' => null,
            'is_active'   => true,
        ]);
        $this->saveProductPhoto($ana->id, $p->id, 'cheese,white', 207);

        $p = Product::create([
            'user_id'     => $ana->id,
            'category'    => 'mlijeko',
            'name'        => 'Kajmak svježi',
            'description' => 'Pravi domaći kajmak skinut sa vrha kuhanog mlijeka. Skuplja se dva dana, lagano posoli i pakuje u teglu od 0,5 kg. Kremast, bogat i neponovljiv ukus uz svježi hljeb i med. Dostupno u ograničenim količinama svaki dan.',
            'price'       => 12.00,
            'price_unit'  => 'kg',
            'fresh_until' => now()->addHours(48),
            'is_active'   => true,
        ]);
        $this->saveProductPhoto($ana->id, $p->id, 'cream,dairy', 208);

        $p = Product::create([
            'user_id'     => $ana->id,
            'category'    => 'mlijeko',
            'name'        => 'Domaća pavlaka (250g)',
            'description' => 'Kisela pavlaka od punomasnog mlijeka, prirodno fermentovana bez zgušnjivača i stabilizatora. Gustoća i ukus kakvi se u trgovinama rijetko nađu. Idealna za đuveč, pasulj, torte i kolače. Pakovanje 250g.',
            'price'       => 3.00,
            'price_unit'  => 'kom',
            'fresh_until' => now()->addHours(48),
            'is_active'   => true,
        ]);
        $this->saveProductPhoto($ana->id, $p->id, 'sour,cream', 209);

        Review::create(['farmer_id' => $anaProfil->id, 'reviewer_name' => 'Bojan K.',    'body' => 'Najbolje mlijeko u okolici Prnjavora, svakog jutra svježe. Djeca ne piju ništa drugo otkako su probala Anino mlijeko — kažu da ima drugačiji ukus.',           'rating' => 5, 'ip_hash' => hash('sha256', '2.1.1.1')]);
        Review::create(['farmer_id' => $anaProfil->id, 'reviewer_name' => 'Snježana T.', 'body' => 'Domaći sir kao iz djetinjstva. Salamura savršena, nije preslano. Kajmak — jednom riječju savršen. Kupujem za slavu i ne žalim ni marke.',                       'rating' => 5, 'ip_hash' => hash('sha256', '2.1.1.2')]);
        Review::create(['farmer_id' => $anaProfil->id, 'reviewer_name' => 'Miloš A.',   'body' => 'Mlijeko izvrsno, ali ponekad nema na stanju jer se brzo rasprodaje. Preporučujem naručiti dan ranije — onda uvijek ima. Vrijedi svake pare.',                    'rating' => 4, 'ip_hash' => hash('sha256', '2.1.1.3')]);
        Review::create(['farmer_id' => $anaProfil->id, 'reviewer_name' => 'Rada V.',    'body' => 'Kupujem od Ane već 4 godine. Nikad razočarana — kvalitet uvijek isti, Ana uvijek ljubazna. Sir i kajmak su posebno dobri uz slavske kolače.',                    'rating' => 5, 'ip_hash' => hash('sha256', '2.1.1.4')]);
        Review::create(['farmer_id' => $anaProfil->id, 'reviewer_name' => 'Nikolina P.','body' => 'Pavlaka je kremasta i gusta, potpuno drugačija od one iz prodavnice. Stavljam je u đuveč, pasulj i torte. Ana je pravi dragulj Konjuhovaca.',                   'rating' => 5, 'ip_hash' => hash('sha256', '2.1.1.5')]);

        // Farmer 3 — Dragan Vujić, med, jaja i povrće, Prnjavor
        $dragan = User::create([
            'name'            => 'Dragan Vujić',
            'email'           => 'dragan@example.com',
            'password'        => Hash::make('password'),
            'role'            => 'farmer',
            'phone'           => '+38763300400',
            'viber'           => '+38763300400',
            'whatsapp'        => '+38763300400',
            'onboarding_step' => null,
        ]);

        $draganProfil = FarmerProfile::create([
            'user_id'     => $dragan->id,
            'farm_name'   => 'Eko gazdinstvo Vujić',
            'description' => 'U Lišnji kod Prnjavora vodim mali eko kompleks koji pokriva sve što je porodici potrebno — 45 košnica pčelinjaka na cvjetnim livadama Trebave, jato slobodnih kokoši i organsko polje krompira. Sve je eko, bez hemije i bez prskanja. Med skupljam dva puta godišnje: proljetni bagremov u maju i ljetni livadski u julu. Jaja su uvijek svježa — kokoši izlaze napolje svakog dana po lijepom vremenu. Krompir kopamo u oktobru i prodajemo direktno, bez posrednika.',
            'city'        => 'prnjavor',
            'address'     => 'Lišnja bb',
            'is_active'   => true,
        ]);

        $this->savePhoto($dragan->id, $draganProfil->id, 'beekeeper,honey', 105, 0);
        $this->savePhoto($dragan->id, $draganProfil->id, 'beehive,apiary', 106, 1, 800, 600);

        $p = Product::create([
            'user_id'     => $dragan->id,
            'category'    => 'med',
            'name'        => 'Livadski med sa Trebave',
            'description' => 'Čisti livadski med sa cvjetnih livada planine Trebave. Sakupljen u julu, bez dodavanja šećera ili voska — 100% prirodan. Taman žutobraon, bogat aromatima divljeg cvijeća. Kristalizira tokom zime, što je znak čistoće. Tegla 1 kg ili 0,5 kg.',
            'price'       => 16.00,
            'price_unit'  => 'kg',
            'fresh_until' => null,
            'is_active'   => true,
        ]);
        $this->saveProductPhoto($dragan->id, $p->id, 'honey,jar', 210);

        $p = Product::create([
            'user_id'     => $dragan->id,
            'category'    => 'med',
            'name'        => 'Bagremov med proljetni',
            'description' => 'Proljetni bagremov med prolazne zlatnožute boje i blagog mirisnog ukusa. Jedna od najcjenjenijih vrsta meda — spor da kristalizira, dugo ostaje tečan i čist. Sakuplja se isključivo u maju. Tegla 1 kg ili 0,5 kg.',
            'price'       => 18.00,
            'price_unit'  => 'kg',
            'fresh_until' => null,
            'is_active'   => true,
        ]);
        $this->saveProductPhoto($dragan->id, $p->id, 'honey,bee', 211);

        $p = Product::create([
            'user_id'     => $dragan->id,
            'category'    => 'jaja',
            'name'        => 'Svježa seoska jaja',
            'description' => 'Jaja slobodno pasenih kokoši hranjenih mješavinom kukuruza, pšenice i svježe trave. Žumanjak tamno narandžaste boje i kremastog ukusa. Skupljamo svaki dan — uvijek svježe. Kutija od 10 ili 30 komada.',
            'price'       => 0.35,
            'price_unit'  => 'kom',
            'fresh_until' => now()->addHours(48),
            'is_active'   => true,
        ]);
        $this->saveProductPhoto($dragan->id, $p->id, 'eggs,farm', 212);

        $p = Product::create([
            'user_id'     => $dragan->id,
            'category'    => 'povrce',
            'name'        => 'Krompir bijeli "Desiree"',
            'description' => 'Domaći bijeli krompir sorte Desiree, bez prskanja pesticidima. Kopan u oktobru i čuvan u hladnom, tamnom podrumu. Brašnjav unutra, hrskav kad se prži. Prodajemo u džakovima od 5, 10 ili 25 kg.',
            'price'       => 0.75,
            'price_unit'  => 'kg',
            'fresh_until' => null,
            'is_active'   => true,
        ]);
        $this->saveProductPhoto($dragan->id, $p->id, 'potato,harvest', 213);

        Review::create(['farmer_id' => $draganProfil->id, 'reviewer_name' => 'Zoran B.',    'body' => 'Med sa Trebave je pravi — kristalizira kako treba, a to je dokaz da nije prerađivan. Kupio sam 3 kg i ne žalim ni marke. Sljedeće godine uzmem 5 kg.',            'rating' => 5, 'ip_hash' => hash('sha256', '3.1.1.1')]);
        Review::create(['farmer_id' => $draganProfil->id, 'reviewer_name' => 'Lidija P.',   'body' => 'Jaja su stvarno posebna — žumanjak narandžast i gust, kajgana ima ukus kakvog odavno nisam osjetila. Djeca tvrde da su ovo "pravi" jaji.',                        'rating' => 5, 'ip_hash' => hash('sha256', '3.1.1.2')]);
        Review::create(['farmer_id' => $draganProfil->id, 'reviewer_name' => 'Radoslav N.', 'body' => 'Krompir odličan, bez prskanja, nije vodan. Preporučujem Eko gazdinstvo Vujić svakome ko voli zdravu, domaću hranu.',                                              'rating' => 5, 'ip_hash' => hash('sha256', '3.1.1.3')]);
        Review::create(['farmer_id' => $draganProfil->id, 'reviewer_name' => 'Vesna O.',    'body' => 'Dragan je uvijek tu kad zatreba. Brz odgovor na Viber, isporuka isti dan ako se naruči ujutro. Bagremov med je posebno ukusan.',                                  'rating' => 4, 'ip_hash' => hash('sha256', '3.1.1.4')]);
    }

    private function savePhoto(int $userId, int $profileId, string $keyword, int $lock, int $position = 0, int $width = 400, int $height = 400): void
    {
        try {
            $url = "https://loremflickr.com/{$width}/{$height}/{$keyword}?lock={$lock}";
            $response = Http::withoutVerifying()->timeout(15)->get($url);
            if ($response->successful()) {
                $filename = "photo_{$position}.jpg";
                $path = "farmers/{$userId}/{$filename}";
                Storage::disk()->put($path, $response->body());
                Photo::create([
                    'photoable_id'   => $profileId,
                    'photoable_type' => FarmerProfile::class,
                    'path'           => $path,
                    'position'       => $position,
                ]);
            }
        } catch (\Throwable) {
            // Network unavailable — skip photo, seeder continues
        }
    }

    private function saveProductPhoto(int $userId, int $productId, string $keyword, int $lock): void
    {
        try {
            $url = "https://loremflickr.com/400/400/{$keyword}?lock={$lock}";
            $response = Http::withoutVerifying()->timeout(15)->get($url);
            if ($response->successful()) {
                $path = "farmers/{$userId}/product_{$productId}.jpg";
                Storage::disk()->put($path, $response->body());
                Photo::create([
                    'photoable_id'   => $productId,
                    'photoable_type' => Product::class,
                    'path'           => $path,
                    'position'       => 0,
                ]);
            }
        } catch (\Throwable) {
            // Network unavailable — skip photo, seeder continues
        }
    }
}
