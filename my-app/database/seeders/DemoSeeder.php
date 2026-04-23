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
            'description' => 'Porodični voćnjak Đurić prostire se na 4 hektara pitomog terena u Vijačanima. Imanje je u porodici tri generacije — djed Stevan zasadio je prve jabuke 1962. Uzgajamo jabuke (Ajdared, Zlatni delišes, Jonatan), šljive (Požegača, Stanlej), kruške (Viljamovka, Konferencija) i nešto trešanja. Hemijsko prskanje ne koristimo od 2005. — samo kaolin i bakar. Suhe šljive i džemovi su dostupni tokom cijele godine, a svježe voće u sezoni od avgusta do oktobra.',
            'city'        => 'prnjavor',
            'address'     => 'Vijačani bb',
            'is_active'   => true,
        ]);

        $this->savePhoto($milica->id, $milicaProfil->id, 'orchard,apple,woman', 107, 0);
        $this->savePhoto($milica->id, $milicaProfil->id, 'apple,orchard,trees', 108, 1, 800, 600);

        $p = Product::create([
            'user_id'     => $milica->id,
            'category'    => 'voce',
            'name'        => 'Jabuke "Ajdared"',
            'description' => 'Krupne, tamnocrvene jabuke slatko-kiselog ukusa — jedna od omiljenih sorti za jelo i kuvanje. Čuvaju se do februara u hladnom podrumu. Prodajemo u drvenim kutijama od 10 kg ili na malo.',
            'price'       => 1.20,
            'price_unit'  => 'kg',
            'fresh_until' => now()->addHours(24),
            'is_active'   => true,
        ]);
        $this->saveProductPhoto($milica->id, $p->id, 'apple,red', 214);

        $p = Product::create([
            'user_id'     => $milica->id,
            'category'    => 'voce',
            'name'        => 'Jabuke "Zlatni delišes"',
            'description' => 'Zlatnožute jabuke blagog, slatkog ukusa sa aromom meda. Izvrsne za svježe jedenje i pite. Čuvaju se do januara. Kutija 10 kg.',
            'price'       => 1.30,
            'price_unit'  => 'kg',
            'fresh_until' => null,
            'is_active'   => true,
        ]);
        $this->saveProductPhoto($milica->id, $p->id, 'apple,yellow', 215);

        $p = Product::create([
            'user_id'     => $milica->id,
            'category'    => 'voce',
            'name'        => 'Kruške "Viljamovka"',
            'description' => 'Sočne i mirisave kruške Viljamovka, zrele u avgustu. Savršene za svježe jedenje ili pravljenje domaćeg soka. Prodajemo na licu mjesta ili dostavljamo u Prnjavor petkom.',
            'price'       => 1.40,
            'price_unit'  => 'kg',
            'fresh_until' => null,
            'is_active'   => true,
        ]);
        $this->saveProductPhoto($milica->id, $p->id, 'pear,fruit', 216);

        $p = Product::create([
            'user_id'     => $milica->id,
            'category'    => 'voce',
            'name'        => 'Suhe šljive "Požegača"',
            'description' => 'Prirodno sušene šljive sorte Požegača na suncu, bez konzervansa i bez sumpora. Tamne, mesnate, slatke. Odlične za kompot, kolače i direktno jedenje. Vrećica 0,5 kg ili 1 kg.',
            'price'       => 4.50,
            'price_unit'  => 'kg',
            'fresh_until' => null,
            'is_active'   => true,
        ]);
        $this->saveProductPhoto($milica->id, $p->id, 'dried,plum', 217);

        $p = Product::create([
            'user_id'     => $milica->id,
            'category'    => 'zimnica',
            'name'        => 'Džem od šljive (tegla 400g)',
            'description' => 'Domaći džem kuhan u kotlu bez konzervansa i boja. Samo šljive i malo šećera — ništa više. Gust, tamnocrven, intenzivnog ukusa. Tegla 400g, idealna za palačinke, kroasane i kolače.',
            'price'       => 3.00,
            'price_unit'  => 'kom',
            'fresh_until' => null,
            'is_active'   => true,
        ]);
        $this->saveProductPhoto($milica->id, $p->id, 'jam,jar', 218);

        Review::create(['farmer_id' => $milicaProfil->id, 'reviewer_name' => 'Anđela M.',   'body' => 'Jabuke "Ajdared" su prekrasne — krupne, hrskave i slatke. Kutija od 10 kg nestane za sedmicu. Već drugu sezonu naručujem isključivo kod Milice.',              'rating' => 5, 'ip_hash' => hash('sha256', '4.1.1.1')]);
        Review::create(['farmer_id' => $milicaProfil->id, 'reviewer_name' => 'Predrag S.',  'body' => 'Džem od šljive je savršen za palačinke — gust i intenzivan. Kupio sam 6 tegli i polovina je već otišla za sedam dana. Preporučujem svima.',                    'rating' => 5, 'ip_hash' => hash('sha256', '4.1.1.2')]);
        Review::create(['farmer_id' => $milicaProfil->id, 'reviewer_name' => 'Gordana K.',  'body' => 'Suhe šljive su odlične za kompot i kolače. Naručila sam 2 kg, pakovanje uredno, isporuka brza. Definitivno se vraćam.',                                         'rating' => 5, 'ip_hash' => hash('sha256', '4.1.1.3')]);
        Review::create(['farmer_id' => $milicaProfil->id, 'reviewer_name' => 'Tomislav B.', 'body' => 'Domaći kvalitet i bez hemije. Jedini minus — ponekad je rasprodato u sezoni, pa treba naručiti unaprijed. Vrijedi svake čekanja.',                               'rating' => 4, 'ip_hash' => hash('sha256', '4.1.1.4')]);

        // Farmer 5 — Nikola Simić, meso i prerađevine, Prnjavor
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
            'description' => 'U Štrpcima kod Prnjavora uzgajam 60 grla ovaca Virtemberg rase i 15 svinja na prirodnoj ispaši. Farma je okružena šumama i livadama — životinje slobodno pasu od aprila do oktobra. Klanje se obavlja isključivo po narudžbi, meso se ne zamrzava. Slaninu i kobasice dimimo sami hladnim dimom bukovine u domaćoj pušnici. Jagnjetina je dostupna u sezoni od marta do maja, svinjetina i prerađevine tokom cijele godine.',
            'city'        => 'prnjavor',
            'address'     => 'Štrpci 14',
            'is_active'   => true,
        ]);

        $this->savePhoto($nikola->id, $nikolaProfil->id, 'sheep,farmer', 109, 0);
        $this->savePhoto($nikola->id, $nikolaProfil->id, 'sheep,pasture', 110, 1, 800, 600);

        $p = Product::create([
            'user_id'     => $nikola->id,
            'category'    => 'meso',
            'name'        => 'Jagnjetina svježa',
            'description' => 'Mlado janje hranjeno majčinim mlijekom i svježom travom, slobodna ispaša. Meso mekano, blijedoružičasto, bez masnog mirisa. Prodajemo cijelo janje (10–14 kg) ili pola, po dogovoru. Klanje po narudžbi — minimum 2 dana unaprijed.',
            'price'       => 12.00,
            'price_unit'  => 'kg',
            'fresh_until' => null,
            'is_active'   => true,
        ]);
        $this->saveProductPhoto($nikola->id, $p->id, 'lamb,meat', 219);

        $p = Product::create([
            'user_id'     => $nikola->id,
            'category'    => 'meso',
            'name'        => 'Domaća slanina dimljena',
            'description' => 'Dimljena slanina od domaće svinje, sušena 3 do 4 mjeseca hladnim dimom bukovine. Slojevi mesa i masnoće su uravnoteženi. Prodajemo narezanu ili cijeli komad po kilogramu.',
            'price'       => 9.00,
            'price_unit'  => 'kg',
            'fresh_until' => null,
            'is_active'   => true,
        ]);
        $this->saveProductPhoto($nikola->id, $p->id, 'bacon,smoked', 220);

        $p = Product::create([
            'user_id'     => $nikola->id,
            'category'    => 'meso',
            'name'        => 'Domaća kobasica dimljena',
            'description' => 'Svinjska kobasica punjena mješavinom mesa i domaćih začina (bijeli luk, biber, paprika). Dimljena hladnim dimom u pušnici od bukovine. Kilogram sadrži 5 do 6 komada. Odlična kuhana, pržena ili sa roštiljem.',
            'price'       => 11.00,
            'price_unit'  => 'kg',
            'fresh_until' => null,
            'is_active'   => true,
        ]);
        $this->saveProductPhoto($nikola->id, $p->id, 'sausage,smoked', 221);

        $p = Product::create([
            'user_id'     => $nikola->id,
            'category'    => 'meso',
            'name'        => 'Suho rebro dimljeno',
            'description' => 'Svinjska rebra suha dimljena, blago nasoljena i odležana 2 do 3 sedmice u dimu. Savršena za kuhanje sa pasuljem i kiselim kupusom. Prodajemo po komadu ili kilogramu.',
            'price'       => 8.50,
            'price_unit'  => 'kg',
            'fresh_until' => null,
            'is_active'   => true,
        ]);
        $this->saveProductPhoto($nikola->id, $p->id, 'ribs,pork', 222);

        $p = Product::create([
            'user_id'     => $nikola->id,
            'category'    => 'meso',
            'name'        => 'Svinjska mast domaća',
            'description' => 'Topljena svinjska mast od domaće svinje, čista i bijela. Nezamjenjiva za proju, vrtanje tijesta i prženje. Tegla od 0,5 kg ili 1 kg. Čuva se godinu dana u hladnjaku.',
            'price'       => 5.00,
            'price_unit'  => 'kg',
            'fresh_until' => null,
            'is_active'   => true,
        ]);
        $this->saveProductPhoto($nikola->id, $p->id, 'pork,fat', 223);

        Review::create(['farmer_id' => $nikolaProfil->id, 'reviewer_name' => 'Petar J.',    'body' => 'Jagnjetina za Đurđevdan je bila savršena — mekano meso, prirodan miris, bez ničega vještačkog. Nikola je pravi majstor za ovčarstvo.',                           'rating' => 5, 'ip_hash' => hash('sha256', '5.1.1.1')]);
        Review::create(['farmer_id' => $nikolaProfil->id, 'reviewer_name' => 'Slavica M.',  'body' => 'Kobasice su fenomenalne! Dim i začini su savršeno odmjereni, nije preslano. Pravim sarmu od kobasice i niko ne može vjerovati da nije iz mesare.',               'rating' => 5, 'ip_hash' => hash('sha256', '5.1.1.2')]);
        Review::create(['farmer_id' => $nikolaProfil->id, 'reviewer_name' => 'Novak D.',    'body' => 'Dimljena slanina od Nikole je po mom ukusu — pravi domaći dim. Naručio sam dva puta i oba puta zadovoljan. Rebra su odlična za pasulj.',                          'rating' => 5, 'ip_hash' => hash('sha256', '5.1.1.3')]);
        Review::create(['farmer_id' => $nikolaProfil->id, 'reviewer_name' => 'Nataša R.',   'body' => 'Nikola je pouzdan, tačan i ljubazan. Jedina napomena — jagnjetinu treba rezervirati unaprijed jer ide brzo u sezoni. Svake preporuke vrijedna farma.',            'rating' => 4, 'ip_hash' => hash('sha256', '5.1.1.4')]);

        // Farmer 6 — Zdravko Marković, rakija i zimnica, Derventa
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
            'description' => 'Treća generacija rakijdžija iz Bosanskog Kobaša kod Dervente. Šljiva Požegača sa našeg voćnjaka ide u bakreni kotao koji je napravio djed Miljan još 1958. Destilacija jednom godišnje, u septembru — rakija odmara u starim hrastovim bačvama minimum godinu dana prije prodaje. Supruga Stana pored toga priprema zimnu zalihu: ajvar od pečene paprike, pinđur, lečo, kiseli kupus i kornišoni. Sve čisto, domaće, bez konzervansa.',
            'city'        => 'derventa',
            'address'     => 'Bosanski Kobaš bb',
            'is_active'   => true,
        ]);

        $this->savePhoto($zdravko->id, $zdravkoProfil->id, 'winery,barrel,man', 111, 0);
        $this->savePhoto($zdravko->id, $zdravkoProfil->id, 'plum,orchard,rural', 112, 1, 800, 600);

        $p = Product::create([
            'user_id'     => $zdravko->id,
            'category'    => 'rakija',
            'name'        => 'Šljivovica odležana 3 godine',
            'description' => 'Šljivovica destilisana od Požegače sa vlastitog voćnjaka, odležana 3 godine u hrastovim bačvama. Lagano žutobraon, 42% alkohola. Flaša 1L bez komercijalne etikete — pravi domaći. Nema je puno, naručite na vrijeme.',
            'price'       => 22.00,
            'price_unit'  => 'l',
            'fresh_until' => null,
            'is_active'   => true,
        ]);
        $this->saveProductPhoto($zdravko->id, $p->id, 'brandy,bottle', 224);

        $p = Product::create([
            'user_id'     => $zdravko->id,
            'category'    => 'rakija',
            'name'        => 'Šljivovica nova berba',
            'description' => 'Svježe destilisana šljivovica od berbe prošle jeseni, bistra kao suza, 40–42% alkohola. Oštrija od odležane, idealna za kulinarske recepte i tople pića zimi.',
            'price'       => 14.00,
            'price_unit'  => 'l',
            'fresh_until' => null,
            'is_active'   => true,
        ]);
        $this->saveProductPhoto($zdravko->id, $p->id, 'plum,spirit', 225);

        $p = Product::create([
            'user_id'     => $zdravko->id,
            'category'    => 'zimnica',
            'name'        => 'Domaći ajvar (tegla 720ml)',
            'description' => 'Pečena paprika sorte "roga" — pekla se na žaru, ljuštila ručno i kuhala 4 sata na laganoj vatri. Bez konzervansa, bez vinskog sirćeta. Tegla 720ml. Ukus koji ne može imati ništa kupljeno.',
            'price'       => 7.00,
            'price_unit'  => 'kom',
            'fresh_until' => null,
            'is_active'   => true,
        ]);
        $this->saveProductPhoto($zdravko->id, $p->id, 'pepper,roasted,jar', 226);

        $p = Product::create([
            'user_id'     => $zdravko->id,
            'category'    => 'zimnica',
            'name'        => 'Pinđur (tegla 400g)',
            'description' => 'Blaži brat od ajvara — kombinacija pečene paprike i patlidžana sa češnjakom. Kuhan lagano, gust i aromatičan. Odličan namaz za hljeb i uz roštilj. Tegla 400g.',
            'price'       => 5.00,
            'price_unit'  => 'kom',
            'fresh_until' => null,
            'is_active'   => true,
        ]);
        $this->saveProductPhoto($zdravko->id, $p->id, 'eggplant,spread', 227);

        $p = Product::create([
            'user_id'     => $zdravko->id,
            'category'    => 'zimnica',
            'name'        => 'Kiseli kupus cijela glavica',
            'description' => 'Kiseljeno u hrastovom buretu od 100 litara, domaća sorta. Prodajemo na komad (1,5–2 kg po glavici) ili u kanisteru od 10 kg. Savršen za sarmu i prilog uz meso. Nije pregust ni premekan.',
            'price'       => 1.20,
            'price_unit'  => 'kg',
            'fresh_until' => null,
            'is_active'   => true,
        ]);
        $this->saveProductPhoto($zdravko->id, $p->id, 'cabbage,fermented', 228);

        Review::create(['farmer_id' => $zdravkoProfil->id, 'reviewer_name' => 'Mirko S.',    'body' => 'Šljivovica iz bakra — pravi stari recept. Tri godine odležavanja u bačvi to se osjeti na svakom gutljaju. Pravo blago za ponijeti u posjetu.',                 'rating' => 5, 'ip_hash' => hash('sha256', '6.1.1.1')]);
        Review::create(['farmer_id' => $zdravkoProfil->id, 'reviewer_name' => 'Dijana B.',   'body' => 'Ajvar je ukusan, gust, pun okusa dimljene paprike. Kupila sam 6 tegli za zimu i nisam jednu otvorila do novembra jer ih ne mogu prestati.',                    'rating' => 5, 'ip_hash' => hash('sha256', '6.1.1.2')]);
        Review::create(['farmer_id' => $zdravkoProfil->id, 'reviewer_name' => 'Borislav T.',  'body' => 'Kiseli kupus odličan za sarmu — kiseo kako treba, nije premekan. Pinđur je novi favorit u porodici uz roštilj.',                                               'rating' => 5, 'ip_hash' => hash('sha256', '6.1.1.3')]);
        Review::create(['farmer_id' => $zdravkoProfil->id, 'reviewer_name' => 'Ljiljana M.',  'body' => 'Zdravko je gostoljubiv domaćin — može se kušati sve prije kupovine. To znači jako puno. Stana je majstor za ajvar.',                                           'rating' => 5, 'ip_hash' => hash('sha256', '6.1.1.4')]);

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
            'description' => 'Na 8 hektara u Lupljanici uzgajamo pšenicu, kukuruz, ječam i suncokret. Uz polje naslijedili smo stari vodeničarski mlin koji smo obnovili 2015. Meljemo kukuruzno i pšenično brašno za domaćinstva i male pekare. Brašno ide pravo iz mlina u vrećice — bez aditiva, poboljšivača ni konzervansa. Zrno je naše, mlin je naš. Minimalna narudžba 10 kg za dostavu u Prnjavor.',
            'city'        => 'prnjavor',
            'address'     => 'Lupljanica bb',
            'is_active'   => true,
        ]);

        $this->savePhoto($vesna->id, $vesnaProfil->id, 'wheat,woman,grain', 113, 0);
        $this->savePhoto($vesna->id, $vesnaProfil->id, 'wheat,harvest,field', 114, 1, 800, 600);

        $p = Product::create([
            'user_id'     => $vesna->id,
            'category'    => 'zitarice',
            'name'        => 'Kukuruzno brašno krupno (5 kg)',
            'description' => 'Mljeveno od žutog domaćeg kukuruza u kamenoj vodenici, pravo za proju, kačamak i polentu. Krupno mljeveno kako treba — proja se diže i ostaje rahla. Vrećica 5 kg.',
            'price'       => 2.50,
            'price_unit'  => 'kg',
            'fresh_until' => null,
            'is_active'   => true,
        ]);
        $this->saveProductPhoto($vesna->id, $p->id, 'cornmeal,flour', 229);

        $p = Product::create([
            'user_id'     => $vesna->id,
            'category'    => 'zitarice',
            'name'        => 'Pšenično brašno T-500 (5 kg)',
            'description' => 'Bijelo pšenično brašno od vlastite pšenice, mljeveno u lokalnom mlinu. Bez aditiva i poboljšivača. Hljeb lijepo naraste, tijesto se lako mijesi. Vrećica 5 kg.',
            'price'       => 3.00,
            'price_unit'  => 'kg',
            'fresh_until' => null,
            'is_active'   => true,
        ]);
        $this->saveProductPhoto($vesna->id, $p->id, 'flour,wheat', 230);

        $p = Product::create([
            'user_id'     => $vesna->id,
            'category'    => 'zitarice',
            'name'        => 'Pšenično integralno brašno (5 kg)',
            'description' => 'Cjelovito pšenično brašno mljeveno sa mekinjama, bogato vlaknima i mineralima. Idealno za integralni hljeb, kekse i đevreke. Vrećica 5 kg.',
            'price'       => 3.50,
            'price_unit'  => 'kg',
            'fresh_until' => null,
            'is_active'   => true,
        ]);
        $this->saveProductPhoto($vesna->id, $p->id, 'wholegrain,flour', 231);

        $p = Product::create([
            'user_id'     => $vesna->id,
            'category'    => 'ostalo',
            'name'        => 'Suncokretovo ulje hladno cijeđeno (1L)',
            'description' => 'Hladno cijeđeno suncokretovo ulje od domaćeg suncokreta, bez rafiniranja i hemije. Tamnoamber boje i intenzivnog ukusa. Izvrsno za salate i dressing. Boca 1L.',
            'price'       => 6.50,
            'price_unit'  => 'l',
            'fresh_until' => null,
            'is_active'   => true,
        ]);
        $this->saveProductPhoto($vesna->id, $p->id, 'sunflower,oil', 232);

        $p = Product::create([
            'user_id'     => $vesna->id,
            'category'    => 'zitarice',
            'name'        => 'Ječam za ishranu stoke i peradi (25 kg)',
            'description' => 'Čist ječam bez herbicida, za ishranu krava, koza i peradi. Bogat skrobom i bjelančevinama. Džak od 25 kg. Dostava u Prnjavor i okolinu.',
            'price'       => 0.55,
            'price_unit'  => 'kg',
            'fresh_until' => null,
            'is_active'   => true,
        ]);
        $this->saveProductPhoto($vesna->id, $p->id, 'barley,grain', 233);

        Review::create(['farmer_id' => $vesnaProfil->id, 'reviewer_name' => 'Mira J.',    'body' => 'Kukuruzno brašno iz Vesninog mlina je pravo — proja ispade nevjerovatna, rahla i zlatna. Nikad se neću vratiti na ono iz prodavnice.',                           'rating' => 5, 'ip_hash' => hash('sha256', '7.1.1.1')]);
        Review::create(['farmer_id' => $vesnaProfil->id, 'reviewer_name' => 'Đorđe N.',   'body' => 'Pšenično brašno bez aditiva — hljeb lijepo naraste i mekano je. Integralno brašno sam probao za kekse, odlično. Svaka preporuka Vesni.',                        'rating' => 5, 'ip_hash' => hash('sha256', '7.1.1.2')]);
        Review::create(['farmer_id' => $vesnaProfil->id, 'reviewer_name' => 'Biljana K.',  'body' => 'Kupujem brašno redovno već godinu dana. Vesna je uvijek uredna i brašno dobro zapakovano, ne prosipa se. Suncokretovo ulje je takođe odlično.',                  'rating' => 4, 'ip_hash' => hash('sha256', '7.1.1.3')]);
        Review::create(['farmer_id' => $vesnaProfil->id, 'reviewer_name' => 'Ratko P.',   'body' => 'Ječam za kokoši — krupan, čist i bez korova. Kokoši ga vole više od kupovnog. Narudžba od 50 kg bila bez problema.',                                             'rating' => 5, 'ip_hash' => hash('sha256', '7.1.1.4')]);

        // Farmer 8 — Slobodan Tešić, med i voće, Kotor Varoš
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
            'description' => 'Na planini Vlašić imam 65 košnica raspoređenih po cvjetnim livadama na 1100 metara nadmorske visine. Med skupljam dva puta godišnje — proljetni bagremov u maju i ljetni livadski sa planine u julu. Pored meda nudim i pčelinji pelud i med u saću. Ispod planine imam mali voćnjak s kruškim i šljivama. Sve se prodaje direktno, bez preprodavaca. Dostavljam u Kotor Varoš i Prnjavor jednom sedmično.',
            'city'        => 'kotor_varos',
            'address'     => 'Garići bb',
            'is_active'   => true,
        ]);

        $this->savePhoto($slobodan->id, $slobodanProfil->id, 'beekeeper,mountain', 115, 0);
        $this->savePhoto($slobodan->id, $slobodanProfil->id, 'beehive,meadow,mountain', 116, 1, 800, 600);

        $p = Product::create([
            'user_id'     => $slobodan->id,
            'category'    => 'med',
            'name'        => 'Bagremov med (1 kg)',
            'description' => 'Proljetni bagremov med sakupljen u maju na livadama ispod Vlašića. Svijetložute boje, blag, aromatičan i spor da kristalizira. Jedna od najtraženijih vrsta meda u RS. Tegla 1 kg ili 0,5 kg.',
            'price'       => 18.00,
            'price_unit'  => 'kg',
            'fresh_until' => null,
            'is_active'   => true,
        ]);
        $this->saveProductPhoto($slobodan->id, $p->id, 'honey,jar', 234);

        $p = Product::create([
            'user_id'     => $slobodan->id,
            'category'    => 'med',
            'name'        => 'Livadski med sa Vlašića',
            'description' => 'Tamni ljetni med bogat polenima planinskog cvijeća sa 1100 metara visine — kantarion, majčina dušica, lavanda. Brzo kristalizira — nepogrešivi znak da nije zagrijavan ni prerađivan. Tegla 1 kg ili 0,5 kg.',
            'price'       => 16.00,
            'price_unit'  => 'kg',
            'fresh_until' => null,
            'is_active'   => true,
        ]);
        $this->saveProductPhoto($slobodan->id, $p->id, 'honey,dark', 235);

        $p = Product::create([
            'user_id'     => $slobodan->id,
            'category'    => 'med',
            'name'        => 'Med u saću (400g)',
            'description' => 'Svježe saće direktno iz košnice — med zatvoren u voštanim ćelijama kako ga pčele ostavljaju. Jede se direktno, vosak se pažljivo žvaće i ispljune. Poseban užitak i idealan poklon. Komad 400g.',
            'price'       => 22.00,
            'price_unit'  => 'kom',
            'fresh_until' => null,
            'is_active'   => true,
        ]);
        $this->saveProductPhoto($slobodan->id, $p->id, 'honeycomb', 236);

        $p = Product::create([
            'user_id'     => $slobodan->id,
            'category'    => 'med',
            'name'        => 'Pčelinji pelud (200g)',
            'description' => 'Svježe skupljeni pčelinji pelud sa planinskih livada Vlašića. Bogat bjelančevinama, aminokiselinama i enzimima. Uzima se kašičica dnevno uz med ili jogurt. Pakovanje 200g.',
            'price'       => 15.00,
            'price_unit'  => 'kom',
            'fresh_until' => null,
            'is_active'   => true,
        ]);
        $this->saveProductPhoto($slobodan->id, $p->id, 'pollen,bee', 237);

        $p = Product::create([
            'user_id'     => $slobodan->id,
            'category'    => 'voce',
            'name'        => 'Kruške "Viljamovka"',
            'description' => 'Sočne i mirisave Viljamovke iz voćnjaka ispod Vlašića, zrele u avgustu. Mekane kad se pritisnu, slatke s aromom vanile. Prodajemo na licu mjesta ili dostavljamo u Prnjavor petkom.',
            'price'       => 1.50,
            'price_unit'  => 'kg',
            'fresh_until' => null,
            'is_active'   => true,
        ]);
        $this->saveProductPhoto($slobodan->id, $p->id, 'pear,fresh', 238);

        Review::create(['farmer_id' => $slobodanProfil->id, 'reviewer_name' => 'Renata P.',  'body' => 'Bagremov med sa Vlašića je poseban — blag, mirisav, djeca ga obožavaju umjesto šećera. Svaka preporuka Slobodanu i njegovom pčelinjaku.',                     'rating' => 5, 'ip_hash' => hash('sha256', '8.1.1.1')]);
        Review::create(['farmer_id' => $slobodanProfil->id, 'reviewer_name' => 'Saša V.',    'body' => 'Livadski med kristalizira brzo — to je jedini pravi dokaz da nije prerađivan. Kupio sam 2 kg i poklonio komšijama koji su odmah naručili sami.',               'rating' => 5, 'ip_hash' => hash('sha256', '8.1.1.2')]);
        Review::create(['farmer_id' => $slobodanProfil->id, 'reviewer_name' => 'Tanja M.',   'body' => 'Slobodan je pčelar sa strašću. Sve mi je objasnio o medu, kristalizaciji i pravilnom čuvanju. Med u saću je poseban doživljaj — nikad to nisam probala.',      'rating' => 5, 'ip_hash' => hash('sha256', '8.1.1.3')]);
        Review::create(['farmer_id' => $slobodanProfil->id, 'reviewer_name' => 'Dragan L.',  'body' => 'Pelud koristim svako jutro i osjećam razliku. Dostava petkom u Prnjavor jako pogodna. Kruške Viljamovka su isto fenomenalne.',                                  'rating' => 4, 'ip_hash' => hash('sha256', '8.1.1.4')]);

        // Farmer 9 — Jasminka Kovač, povrće i zimnica, Bijeljina [NOVO]
        $jasminka = User::create([
            'name'            => 'Jasminka Kovač',
            'email'           => 'jasminka.kovac@example.com',
            'password'        => Hash::make('password'),
            'role'            => 'farmer',
            'phone'           => '+38765910700',
            'viber'           => '+38765910700',
            'whatsapp'        => '+38765910700',
            'onboarding_step' => null,
        ]);

        $jasminkaProfile = FarmerProfile::create([
            'user_id'     => $jasminka->id,
            'farm_name'   => 'Povrtnjak Kovač',
            'description' => 'Bijeljinsko polje — crnica duboka metar i po, najplodnija zemlja u Republici Srpskoj. Uzgajam povrće na 2 hektara porodičnog imanja: paradajz, paprika, tikva, crni luk, šargarepa i pasulj. Sjeme čuvam sama, sve su to stare domaće sorte. Krajem ljeta i u ranu jesen pripremam zimsku zalihu: ajvar od pečene paprike, ketchup, lečo i kompoti. Dostavljam u Bijeljinu srijedom i subotom, mogućnost dostave i poštom.',
            'city'        => 'bijeljina',
            'address'     => 'Donje Crnjelovo bb',
            'is_active'   => true,
        ]);

        $this->savePhoto($jasminka->id, $jasminkaProfile->id, 'woman,garden,vegetables', 117, 0);
        $this->savePhoto($jasminka->id, $jasminkaProfile->id, 'vegetable,field,rows', 118, 1, 800, 600);

        $p = Product::create([
            'user_id'     => $jasminka->id,
            'category'    => 'povrce',
            'name'        => 'Paradajz "Volovski" za zimnice',
            'description' => 'Krupni mesnati volovski paradajz — savršen za kuvani sos, ketchup i džemove. Uzgojen na crnici bez pesticida. Sezona jula i avgusta. Minimum 5 kg po narudžbi.',
            'price'       => 1.50,
            'price_unit'  => 'kg',
            'fresh_until' => now()->addHours(24),
            'is_active'   => true,
        ]);
        $this->saveProductPhoto($jasminka->id, $p->id, 'tomato,harvest', 239);

        $p = Product::create([
            'user_id'     => $jasminka->id,
            'category'    => 'povrce',
            'name'        => 'Paprika šarena ljuta i blaga',
            'description' => 'Mješavina blagih i ljutih paprika u crvenoj, narančastoj i žutoj boji. Odlična za ajvar, kiseljenje i svježe jedenje. Uzgojena bez pesticida na bijeljinskim njivama.',
            'price'       => 1.20,
            'price_unit'  => 'kg',
            'fresh_until' => now()->addHours(24),
            'is_active'   => true,
        ]);
        $this->saveProductPhoto($jasminka->id, $p->id, 'pepper,hot', 240);

        $p = Product::create([
            'user_id'     => $jasminka->id,
            'category'    => 'povrce',
            'name'        => 'Bundeva tikva (1–5 kg)',
            'description' => 'Narandžasta bundeva uzgojena bez hemije. Savršena za krem-supu, pitu od bundeve i kompot. Prodajemo cijelu ili narezanu na komade. Sezona septembar–oktobar.',
            'price'       => 0.60,
            'price_unit'  => 'kg',
            'fresh_until' => null,
            'is_active'   => true,
        ]);
        $this->saveProductPhoto($jasminka->id, $p->id, 'pumpkin,harvest', 241);

        $p = Product::create([
            'user_id'     => $jasminka->id,
            'category'    => 'povrce',
            'name'        => 'Šargarepa svježa (kg)',
            'description' => 'Krupna, slatka šargarepa bez pesticida. Svježe izvučena iz bijeljinske crnice. Savršena za sokove, supu i prilog. Prodajemo u mrežama od 2 kg ili 5 kg.',
            'price'       => 1.00,
            'price_unit'  => 'kg',
            'fresh_until' => now()->addHours(48),
            'is_active'   => true,
        ]);
        $this->saveProductPhoto($jasminka->id, $p->id, 'carrot,fresh', 242);

        $p = Product::create([
            'user_id'     => $jasminka->id,
            'category'    => 'zimnica',
            'name'        => 'Domaći ketchup (tegla 720ml)',
            'description' => 'Ketchup kuhan od volovskog paradajza, luka i začina — bez šećera, bez konzervansa, bez octa iz industrije. Gust, tamnocrven, pun ukusa. Tegla 720ml.',
            'price'       => 5.50,
            'price_unit'  => 'kom',
            'fresh_until' => null,
            'is_active'   => true,
        ]);
        $this->saveProductPhoto($jasminka->id, $p->id, 'ketchup,tomato', 243);

        Review::create(['farmer_id' => $jasminkaProfile->id, 'reviewer_name' => 'Milorad T.', 'body' => 'Bijeljinska crnica daje poseban ukus povrću — paradajz je sladak i mesnast kao nigde drugde. Naručujem cijelo ljeto za zimnicu.',                              'rating' => 5, 'ip_hash' => hash('sha256', '9.1.1.1')]);
        Review::create(['farmer_id' => $jasminkaProfile->id, 'reviewer_name' => 'Sanja B.',   'body' => 'Paprika je odlična za ajvar — mesnata, sočna, bez voštanog premaza. Uz Jasminkin paradajz napravila sam najbolji ajvar u životu.',                            'rating' => 5, 'ip_hash' => hash('sha256', '9.1.1.2')]);
        Review::create(['farmer_id' => $jasminkaProfile->id, 'reviewer_name' => 'Mirjana L.',  'body' => 'Šargarepa je slatka i hrskava — ništa slično se ne može naći u prodavnici. Ketchup je bogat i gust, djeca lude za njim.',                                    'rating' => 5, 'ip_hash' => hash('sha256', '9.1.1.3')]);
        Review::create(['farmer_id' => $jasminkaProfile->id, 'reviewer_name' => 'Darko V.',   'body' => 'Jasminka je pouzdana i komunikativna. Bundeva je bila krupna i slatka, krem-supa savršena. Svaka preporuka.',                                                   'rating' => 4, 'ip_hash' => hash('sha256', '9.1.1.4')]);

        // Farmer 10 — Mitar Savić, govedo, mlijeko i meso, Banja Luka [NOVO]
        $mitar = User::create([
            'name'            => 'Mitar Savić',
            'email'           => 'mitar.savic@example.com',
            'password'        => Hash::make('password'),
            'role'            => 'farmer',
            'phone'           => '+38766450800',
            'viber'           => '+38766450800',
            'whatsapp'        => null,
            'onboarding_step' => null,
        ]);

        $mitarProfile = FarmerProfile::create([
            'user_id'     => $mitar->id,
            'farm_name'   => 'Farma Savić — govedárstvo',
            'description' => 'Na imanju od 25 hektara uz rijeku Vrbas kod Banja Luke uzgajam 35 grla Simentalke — bh. autohtone rase poznate po odličnom mesu i mlijeku. Krave daju 15 do 18 litara mlijeka dnevno. Mlijeko pasteriziramo sami. Pored mlijeka nudim goveđe meso i tele po narudžbi. Životinje pasu slobodno do oktobra, bez krmnih aditiva i antibiotika. Dostava u Banja Luku svakodnevno, okolina po dogovoru.',
            'city'        => 'banja_luka',
            'address'     => 'Kola bb, Banja Luka',
            'is_active'   => true,
        ]);

        $this->savePhoto($mitar->id, $mitarProfile->id, 'cattle,farmer,man', 119, 0);
        $this->savePhoto($mitar->id, $mitarProfile->id, 'cattle,pasture,river', 120, 1, 800, 600);

        $p = Product::create([
            'user_id'     => $mitar->id,
            'category'    => 'mlijeko',
            'name'        => 'Svježe kravlje mlijeko',
            'description' => 'Pasterizirano punomasno mlijeko Simentalki sa naše farme, punjeno u flaše od 1L. Bogato i ukusno zbog slobodne ispaše na livadama pored Vrbasa. Preuzimanje na farmi ili dostava u Banja Luku.',
            'price'       => 1.60,
            'price_unit'  => 'l',
            'fresh_until' => now()->addHours(24),
            'is_active'   => true,
        ]);
        $this->saveProductPhoto($mitar->id, $p->id, 'milk,cow', 244);

        $p = Product::create([
            'user_id'     => $mitar->id,
            'category'    => 'mlijeko',
            'name'        => 'Domaće maslo (puter)',
            'description' => 'Pravo domaće maslo od vrnja svježeg mlijeka, bućkano ručno. Intenzivne žute boje i bogatog mliječnog ukusa. Bez soli ili lagano posoljeno po želji. Tegla 250g.',
            'price'       => 14.00,
            'price_unit'  => 'kg',
            'fresh_until' => null,
            'is_active'   => true,
        ]);
        $this->saveProductPhoto($mitar->id, $p->id, 'butter,dairy', 245);

        $p = Product::create([
            'user_id'     => $mitar->id,
            'category'    => 'meso',
            'name'        => 'Goveđa govedina mješano (kg)',
            'description' => 'Mješano goveđe meso bez kosti od Simentalke, slobodna ispaša. Svježe klano po narudžbi. Prodajemo u komadima od 1 do 5 kg, pakujemo vakuumski za transport. Jelo od ovog mesa ne treba mnogo začina.',
            'price'       => 14.00,
            'price_unit'  => 'kg',
            'fresh_until' => null,
            'is_active'   => true,
        ]);
        $this->saveProductPhoto($mitar->id, $p->id, 'beef,meat', 246);

        $p = Product::create([
            'user_id'     => $mitar->id,
            'category'    => 'meso',
            'name'        => 'Teleći but',
            'description' => 'Nježni teleći but od teleta starog 6 do 8 sedmica, slobodna ispaša i mlijeko. Blijedoružičasto, mekano i bez masnog mirisa. Klanje po narudžbi uz avans. Vakuumski pakovano.',
            'price'       => 18.00,
            'price_unit'  => 'kg',
            'fresh_until' => null,
            'is_active'   => true,
        ]);
        $this->saveProductPhoto($mitar->id, $p->id, 'veal,meat', 247);

        Review::create(['farmer_id' => $mitarProfile->id, 'reviewer_name' => 'Dragana P.',  'body' => 'Mlijeko od Simentalki je kremasto i bogato — odmah se osjeća da krave pasu na livadi. Djeca su prestala tražiti kupovno mlijeko.',                              'rating' => 5, 'ip_hash' => hash('sha256', '10.1.1.1')]);
        Review::create(['farmer_id' => $mitarProfile->id, 'reviewer_name' => 'Stjepan V.',  'body' => 'Goveđa govedina je mekana i ukusna — kuhao sam čorbu i meso se samo raspalo. Vakuumsko pakovanje je odlično za transport.',                                    'rating' => 5, 'ip_hash' => hash('sha256', '10.1.1.2')]);
        Review::create(['farmer_id' => $mitarProfile->id, 'reviewer_name' => 'Irena K.',    'body' => 'Domaće maslo je nestvarne boje i ukusa — žuto kao sunce. Bez soli, topi se na hljeb savršeno. Ništa slično se ne može naći u Banja Luci.',                      'rating' => 5, 'ip_hash' => hash('sha256', '10.1.1.3')]);
        Review::create(['farmer_id' => $mitarProfile->id, 'reviewer_name' => 'Nemanja B.',  'body' => 'Mitar je pouzdan i tačan. Teleće meso je bijelo i mekano kao u restoranu. Jedino što bi mogao poboljšati je malo više fleksibilnosti s terminima isporuke.',    'rating' => 4, 'ip_hash' => hash('sha256', '10.1.1.4')]);

        // Farmer 11 — Žana Milić, ljekovito bilje i čajevi, Trebinje [NOVO]
        $zana = User::create([
            'name'            => 'Žana Milić',
            'email'           => 'zana.milic@example.com',
            'password'        => Hash::make('password'),
            'role'            => 'farmer',
            'phone'           => '+38765180900',
            'viber'           => '+38765180900',
            'whatsapp'        => '+38765180900',
            'onboarding_step' => null,
        ]);

        $zanaProfile = FarmerProfile::create([
            'user_id'     => $zana->id,
            'farm_name'   => 'Livada i bašta Milić',
            'description' => 'Trebinjski krs — tvrda zemlja ali daje najmirisnije ljekovito bilje na Balkanu. Bavim se branjem i uzgojem ljekovitog bilja od 2010. Uzgajam lavandu, žalfiju, majčinu dušicu, origano i kantarion na sunčanim trebinjskim padinama. Sve se suši na čistom suncu i vjetru, pakuje ručno u papirne vrećice. Pored čajeva nudim i med od lavande i sušene mirisne bukete. Dostava poštom u BiH i Srbiju u roku od 3 dana.',
            'city'        => 'trebinje',
            'address'     => 'Bregovi bb, Trebinje',
            'is_active'   => true,
        ]);

        $this->savePhoto($zana->id, $zanaProfile->id, 'lavender,woman,garden', 121, 0);
        $this->savePhoto($zana->id, $zanaProfile->id, 'lavender,field,purple', 122, 1, 800, 600);

        $p = Product::create([
            'user_id'     => $zana->id,
            'category'    => 'ostalo',
            'name'        => 'Čaj od majčine dušice (50g)',
            'description' => 'Sušena majčina dušica sa trebinjskih padina, brana u cvatu. Preparat koji se koristi za grlo, kašalj i probavu vijekovima. Intenzivan miris i ukus. Papirna vrećica 50g.',
            'price'       => 4.00,
            'price_unit'  => 'kom',
            'fresh_until' => null,
            'is_active'   => true,
        ]);
        $this->saveProductPhoto($zana->id, $p->id, 'thyme,herb', 248);

        $p = Product::create([
            'user_id'     => $zana->id,
            'category'    => 'ostalo',
            'name'        => 'Čaj od žalfije (50g)',
            'description' => 'Sušena žalfija brana u junu, u punom cvatu. Koristi se za grlo, znojenje i probavne smetnje. Mediteranski recept koji trebinjske babe poznaju od davnine. Papirna vrećica 50g.',
            'price'       => 4.50,
            'price_unit'  => 'kom',
            'fresh_until' => null,
            'is_active'   => true,
        ]);
        $this->saveProductPhoto($zana->id, $p->id, 'sage,herb', 249);

        $p = Product::create([
            'user_id'     => $zana->id,
            'category'    => 'ostalo',
            'name'        => 'Sušena lavanda (50g)',
            'description' => 'Mirisni snopovi trebinjske lavande sušeni na suncu. Idealna za mirisne jastuke, ormare i dekoru stola. Intenzivan miris koji traje godinama. Papirna vrećica 50g ili mali buket za poklon.',
            'price'       => 5.00,
            'price_unit'  => 'kom',
            'fresh_until' => null,
            'is_active'   => true,
        ]);
        $this->saveProductPhoto($zana->id, $p->id, 'lavender,dried', 250);

        $p = Product::create([
            'user_id'     => $zana->id,
            'category'    => 'med',
            'name'        => 'Med od lavande (0,5 kg)',
            'description' => 'Rijetki med od lavande uzgojene na trebinjskim padinama. Suradnja sa lokalnim pčelarom. Blag, lagan, sa prepoznatljivom aromom lavande. Idealan poklon i prirodni lijek za nesanicu. Tegla 0,5 kg.',
            'price'       => 22.00,
            'price_unit'  => 'kom',
            'fresh_until' => null,
            'is_active'   => true,
        ]);
        $this->saveProductPhoto($zana->id, $p->id, 'lavender,honey', 251);

        $p = Product::create([
            'user_id'     => $zana->id,
            'category'    => 'ostalo',
            'name'        => 'Origano sušeni (30g)',
            'description' => 'Divlji trebinjski origano branja sa kamenitih padina, intenzivan i aromatičan. Koristite uz pizzu, meso i salate — daleko jači od kupovnog. Papirna vrećica 30g.',
            'price'       => 3.50,
            'price_unit'  => 'kom',
            'fresh_until' => null,
            'is_active'   => true,
        ]);
        $this->saveProductPhoto($zana->id, $p->id, 'oregano,herb', 252);

        Review::create(['farmer_id' => $zanaProfile->id, 'reviewer_name' => 'Jelena S.',   'body' => 'Majčina dušica od Žane je prava — gusto pakovanje, snažan miris. Brat ima hroničan kašalj i ovo mu jedino pomaže osim lijekova. Naručujem redovno.',          'rating' => 5, 'ip_hash' => hash('sha256', '11.1.1.1')]);
        Review::create(['farmer_id' => $zanaProfile->id, 'reviewer_name' => 'Aleksandar M.','body' => 'Med od lavande je jedinstven — blag i aromatičan. Dao sam poklon baki za Novu godinu i bila je oduševljena. Odlično pakovanje.',                               'rating' => 5, 'ip_hash' => hash('sha256', '11.1.1.2')]);
        Review::create(['farmer_id' => $zanaProfile->id, 'reviewer_name' => 'Ivana T.',    'body' => 'Sušena lavanda iz Trebinja miriše na ljeto i sunce. Stavila sam vrećice po ormarima i soba je mirisala sedmicama. Dostava poštom bila brza.',                   'rating' => 5, 'ip_hash' => hash('sha256', '11.1.1.3')]);
        Review::create(['farmer_id' => $zanaProfile->id, 'reviewer_name' => 'Miroslav R.', 'body' => 'Origano je dvostruko jači od kupovnog — malo treba za puno mirisa. Žana je stručna i objasni sve o biljkama. Svaka preporuka.',                                  'rating' => 5, 'ip_hash' => hash('sha256', '11.1.1.4')]);
        Review::create(['farmer_id' => $zanaProfile->id, 'reviewer_name' => 'Zorica K.',   'body' => 'Čaj od žalfije pomaže mi za grlo bolji od apotečkih kapsula. Narudžba dolazi uredna i mirisna poštom. Jedini prigovor — ponekad nema zaliha u proljeće.',      'rating' => 4, 'ip_hash' => hash('sha256', '11.1.1.5')]);

        // Farmer 12 — Mirsada Filipović, voće i džemovi, Banja Luka
        $mirsada = User::create([
            'name'            => 'Mirsada Filipović',
            'email'           => 'mirsada.filipovic@example.com',
            'password'        => Hash::make('password'),
            'role'            => 'farmer',
            'phone'           => '+38766560900',
            'viber'           => '+38766560900',
            'whatsapp'        => '+38766560900',
            'onboarding_step' => null,
        ]);

        $mirsadaProfile = FarmerProfile::create([
            'user_id'     => $mirsada->id,
            'farm_name'   => 'Voćnjak i bašta Filipović',
            'description' => 'Porodično imanje na rubu Banja Luke — mala bašta, ali bogata i pažljivo obrađena. Uzgajamo jagode, maline, kupine i trešnje bez pesticida. Krajem ljeta kuhamo džemove, kompote i sirupe po starim receptima moje majke. Posebnost je sirup od bazge koji skupljamo ručno na početku juna. Dostava u Banja Luku svakim danom, poštom širom BiH.',
            'city'        => 'banja_luka',
            'address'     => 'Lazarevo bb, Banja Luka',
            'is_active'   => true,
        ]);

        $this->savePhoto($mirsada->id, $mirsadaProfile->id, 'strawberry,woman,garden', 123, 0);
        $this->savePhoto($mirsada->id, $mirsadaProfile->id, 'strawberry,raspberry,garden', 129, 1, 800, 600);

        $p = Product::create(['user_id' => $mirsada->id, 'category' => 'voce',    'name' => 'Jagode svježe',               'description' => 'Slatke sorte "Clery" i "Alba", svježe ubrane svako jutro. Bez pesticida, prodajemo u korpicama od 0,5 kg ili 1 kg. Sezona april–jun.', 'price' => 3.00, 'price_unit' => 'kg', 'fresh_until' => now()->addHours(24), 'is_active' => true]);
        $this->saveProductPhoto($mirsada->id, $p->id, 'strawberry,fresh,red', 253);

        $p = Product::create(['user_id' => $mirsada->id, 'category' => 'voce',    'name' => 'Maline svježe',               'description' => 'Sočne domaće maline, sezona juna i jula. Prodajemo u korpicama od 0,5 kg. Ubrane isti dan ujutro — ne stoje dugo, naručite na vrijeme.', 'price' => 4.00, 'price_unit' => 'kg', 'fresh_until' => now()->addHours(24), 'is_active' => true]);
        $this->saveProductPhoto($mirsada->id, $p->id, 'raspberry,fresh,red', 254);

        $p = Product::create(['user_id' => $mirsada->id, 'category' => 'zimnica', 'name' => 'Džem od jagode (tegla 400g)', 'description' => 'Domaći džem od svježih jagoda, kuhan bez konzervansa. Samo jagode i malo šećera — gust i tamnocrven. Tegla 400g.', 'price' => 3.50, 'price_unit' => 'kom', 'fresh_until' => null, 'is_active' => true]);
        $this->saveProductPhoto($mirsada->id, $p->id, 'strawberry,jam,jar', 255);

        $p = Product::create(['user_id' => $mirsada->id, 'category' => 'zimnica', 'name' => 'Kompot od trešnje (tegla 720ml)', 'description' => 'Trešnje kuhane u laganom šećernom sirupu, bez konzervansa. Tamnocrven, slatko-kiselkast kompot koji miriše na ljeto. Tegla 720ml.', 'price' => 5.00, 'price_unit' => 'kom', 'fresh_until' => null, 'is_active' => true]);
        $this->saveProductPhoto($mirsada->id, $p->id, 'cherry,compote,jar', 256);

        $p = Product::create(['user_id' => $mirsada->id, 'category' => 'ostalo',  'name' => 'Sirup od bazge (0,75L)',       'description' => 'Ručno skupljeni cvjetovi bazge u junu, kuhani u sirupu sa limunom. Osvježavajući, aromatičan, razrijeđen s vodom daje ljetni sok kakav se ne može kupiti. Boca 0,75L.', 'price' => 8.00, 'price_unit' => 'kom', 'fresh_until' => null, 'is_active' => true]);
        $this->saveProductPhoto($mirsada->id, $p->id, 'elderflower,syrup,bottle', 257);

        Review::create(['farmer_id' => $mirsadaProfile->id, 'reviewer_name' => 'Bojana T.', 'body' => 'Jagode su nevjerovatne — slatke, mirisne, bez voštanog premaza. Kupujem svake sedmice dok traje sezona. Djeca obожavaju.',                       'rating' => 5, 'ip_hash' => hash('sha256', '12.1.1.1')]);
        Review::create(['farmer_id' => $mirsadaProfile->id, 'reviewer_name' => 'Goran N.',  'body' => 'Sirup od bazge je posebno dobar — nije preslatk, pravi ljetni ukus. Kupio sam 4 flaše i nije ni jedna ostala do avgusta.',                     'rating' => 5, 'ip_hash' => hash('sha256', '12.1.1.2')]);
        Review::create(['farmer_id' => $mirsadaProfile->id, 'reviewer_name' => 'Suzana P.', 'body' => 'Džem od jagode je gust i aromatičan — ništa slično nisam probala. Mirsada je ljubazna i uvijek isporuči na vrijeme.',                           'rating' => 5, 'ip_hash' => hash('sha256', '12.1.1.3')]);
        Review::create(['farmer_id' => $mirsadaProfile->id, 'reviewer_name' => 'Darko K.',  'body' => 'Maline su svježe i ukusne, ali ponekad nema zaliha jer se brzo rasprodaju. Preporučujem naručiti dan ranije.',                                  'rating' => 4, 'ip_hash' => hash('sha256', '12.1.1.4')]);

        // Farmer 13 — Radoslav Arsenić, živinarska farma, Doboj
        $radoslav = User::create([
            'name'            => 'Radoslav Arsenić',
            'email'           => 'radoslav.arsenic@example.com',
            'password'        => Hash::make('password'),
            'role'            => 'farmer',
            'phone'           => '+38763720400',
            'viber'           => '+38763720400',
            'whatsapp'        => null,
            'onboarding_step' => null,
        ]);

        $radoslavProfile = FarmerProfile::create([
            'user_id'     => $radoslav->id,
            'farm_name'   => 'Živinarska farma Arsenić',
            'description' => 'U Makljenovcu kod Doboja uzgajam 300 kokoši, 80 ćurki i 50 pačaka na otvorenom sistemu — slobodan izlaz, prirodna hrana bez antibiotika. Pored živih ptičjih mesa, nudim svježa jaja i domaće dimljene kobasice. Isporuka u Doboj svaki dan, okolinu RS poštom ili dogovoreno.',
            'city'        => 'doboj',
            'address'     => 'Makljenovac bb',
            'is_active'   => true,
        ]);

        $this->savePhoto($radoslav->id, $radoslavProfile->id, 'chicken,farmer,man', 124, 0);
        $this->savePhoto($radoslav->id, $radoslavProfile->id, 'chicken,poultry,farm', 130, 1, 800, 600);

        $p = Product::create(['user_id' => $radoslav->id, 'category' => 'meso',   'name' => 'Svježe pileće meso',            'description' => 'Pile slobodnog uzgoja, hranjeno kukuruzom i pšenicom bez antibiotika. Meso žuto i čvrsto, prirodan miris. Klanje po narudžbi, eviscerirano i vakuumski pakovano. Minimum 1,5 kg.', 'price' => 6.50, 'price_unit' => 'kg', 'fresh_until' => now()->addHours(24), 'is_active' => true]);
        $this->saveProductPhoto($radoslav->id, $p->id, 'chicken,meat,fresh', 258);

        $p = Product::create(['user_id' => $radoslav->id, 'category' => 'meso',   'name' => 'Ćureće meso svježe',            'description' => 'Ćurka slobodnog uzgoja, prirodna ishrana. Meso bijelo i sočno, nisko masno. Prodajemo cijelu ćurku (3–5 kg) ili dijelove. Klanje po narudžbi uz 2 dana unaprijed.', 'price' => 7.50, 'price_unit' => 'kg', 'fresh_until' => null, 'is_active' => true]);
        $this->saveProductPhoto($radoslav->id, $p->id, 'turkey,meat,farm', 259);

        $p = Product::create(['user_id' => $radoslav->id, 'category' => 'jaja',   'name' => 'Svježa jaja slobodnih kokoši',  'description' => 'Jaja kokoši koje izlaze napolje svaki dan i hrane se prirodnom hranom. Žumanjak tamno narandžast. Skupljamo svakog jutra — uvijek svježe. Kutija 10 ili 30 komada.', 'price' => 0.40, 'price_unit' => 'kom', 'fresh_until' => now()->addHours(48), 'is_active' => true]);
        $this->saveProductPhoto($radoslav->id, $p->id, 'eggs,fresh,farm,orange', 260);

        $p = Product::create(['user_id' => $radoslav->id, 'category' => 'meso',   'name' => 'Pileća kobasica dimljena',       'description' => 'Kobasica od pilećeg mesa sa začinima, dimljena hladnim dimom bukovine. Laka, niskomasna alternativa svinjskoj kobasici. Kilogram — 5 do 6 komada.', 'price' => 9.00, 'price_unit' => 'kg', 'fresh_until' => null, 'is_active' => true]);
        $this->saveProductPhoto($radoslav->id, $p->id, 'sausage,chicken,smoked', 261);

        $p = Product::create(['user_id' => $radoslav->id, 'category' => 'meso',   'name' => 'Pačja mast (tegla 0,5 kg)',      'description' => 'Topljena pačja mast od slobodnih pačaka, čista i zlatnožuta. Nezamjenjiva za prženje krumpira i pripremu pečenja. Blažeg ukusa od svinjske, manje zasićenih masti.', 'price' => 7.00, 'price_unit' => 'kom', 'fresh_until' => null, 'is_active' => true]);
        $this->saveProductPhoto($radoslav->id, $p->id, 'duck,fat,jar,golden', 262);

        Review::create(['farmer_id' => $radoslavProfile->id, 'reviewer_name' => 'Tatjana R.',  'body' => 'Pileće meso je žuto i čvrsto — odmah se vidi da je slobodnog uzgoja. Čorba od ovog pileta je nevjerovatna, sasvim drugačija od supermarketskog.',           'rating' => 5, 'ip_hash' => hash('sha256', '13.1.1.1')]);
        Review::create(['farmer_id' => $radoslavProfile->id, 'reviewer_name' => 'Vladan M.',   'body' => 'Jaja su odlična — žumanjak narandžast i gust. Kupujem za cjelu porodicu i nikad razočaran. Radoslav uvijek isporuči na dogovoreno vrijeme.',               'rating' => 5, 'ip_hash' => hash('sha256', '13.1.1.2')]);
        Review::create(['farmer_id' => $radoslavProfile->id, 'reviewer_name' => 'Maja S.',     'body' => 'Pileća kobasica je fenomenalna — laka, ukusna, nije masna. Djeca je vole više od svinjske. Pravi domaći dim.',                                              'rating' => 5, 'ip_hash' => hash('sha256', '13.1.1.3')]);
        Review::create(['farmer_id' => $radoslavProfile->id, 'reviewer_name' => 'Boško J.',    'body' => 'Ćurka za slavu bila je savršena — bijelo meso, sočno, mekano. Radoslav je pouzdan i ljubazan. Jedino bi trebalo više fleksibilnosti s veličinom.',          'rating' => 4, 'ip_hash' => hash('sha256', '13.1.1.4')]);

        // Farmer 14 — Nataša Đorđić, šumsko voće i zimnica, Doboj
        $natasa = User::create([
            'name'            => 'Nataša Đorđić',
            'email'           => 'natasa.djordic@example.com',
            'password'        => Hash::make('password'),
            'role'            => 'farmer',
            'phone'           => '+38765330450',
            'viber'           => '+38765330450',
            'whatsapp'        => '+38765330450',
            'onboarding_step' => null,
        ]);

        $natasaProfile = FarmerProfile::create([
            'user_id'     => $natasa->id,
            'farm_name'   => 'Šumska bašta Đorđić',
            'description' => 'Imam malu šumsku baštu na sjevernim padinama Ozrena gdje rastu kupine, borovnice i divlje maline. Pored šumskog voća, uzgajam jabuke i kruške stare sorte. Krajem ljeta radim džemove i sokove po receptima koje sam naslijedila od bake. Sve isporučujem poštom — pakujem pažljivo da stigne zdravo.',
            'city'        => 'doboj',
            'address'     => 'Ozren bb',
            'is_active'   => true,
        ]);

        $this->savePhoto($natasa->id, $natasaProfile->id, 'berries,woman,garden', 125, 0);
        $this->savePhoto($natasa->id, $natasaProfile->id, 'blueberry,blackberry,forest', 131, 1, 800, 600);

        $p = Product::create(['user_id' => $natasa->id, 'category' => 'voce',    'name' => 'Kupine svježe',                  'description' => 'Krupne, tamne kupine sa sjenovitih padina Ozrena. Slatke i aromatične, sezona jula i avgusta. Prodajemo u korpicama od 0,5 kg. Ubrane isti dan.', 'price' => 4.50, 'price_unit' => 'kg', 'fresh_until' => now()->addHours(24), 'is_active' => true]);
        $this->saveProductPhoto($natasa->id, $p->id, 'blackberry,fresh,dark', 263);

        $p = Product::create(['user_id' => $natasa->id, 'category' => 'voce',    'name' => 'Borovnice svježe',               'description' => 'Divlje borovnice sa ozrenskih šuma, sitne ali izuzetno aromatične i bogate antioksidansima. Sezona jula. Prodajemo u korpicama od 0,25 ili 0,5 kg.', 'price' => 6.00, 'price_unit' => 'kg', 'fresh_until' => now()->addHours(24), 'is_active' => true]);
        $this->saveProductPhoto($natasa->id, $p->id, 'blueberry,fresh,wild', 264);

        $p = Product::create(['user_id' => $natasa->id, 'category' => 'zimnica', 'name' => 'Džem od kupine (tegla 400g)',     'description' => 'Džem kuhan od svježih kupina sa Ozrena, bez konzervansa. Intenzivno ljubičastone boje i jakog aromata. Savršen uz sir, palačinke i kolače. Tegla 400g.', 'price' => 4.00, 'price_unit' => 'kom', 'fresh_until' => null, 'is_active' => true]);
        $this->saveProductPhoto($natasa->id, $p->id, 'blackberry,jam,jar,purple', 265);

        $p = Product::create(['user_id' => $natasa->id, 'category' => 'zimnica', 'name' => 'Džem od borovnice (tegla 400g)',  'description' => 'Džem od divljih borovnica — rijedak i dragocjen. Tamnomodre boje, gustog konzistencija i intenzivnog ukusa. Bogat prirodnim pigmentima. Tegla 400g.', 'price' => 4.50, 'price_unit' => 'kom', 'fresh_until' => null, 'is_active' => true]);
        $this->saveProductPhoto($natasa->id, $p->id, 'blueberry,jam,jar,dark', 266);

        $p = Product::create(['user_id' => $natasa->id, 'category' => 'med',     'name' => 'Med od livadskog cvijeća',        'description' => 'Miješani livadski med sakupljen sa ozrenskih livada u saradnji s lokalnim pčelarom. Tamnobraon, kristalizira brzo, pun aroma divljeg cvijeća. Tegla 0,5 kg.', 'price' => 15.00, 'price_unit' => 'kg', 'fresh_until' => null, 'is_active' => true]);
        $this->saveProductPhoto($natasa->id, $p->id, 'wildflower,honey,jar', 267);

        Review::create(['farmer_id' => $natasaProfile->id, 'reviewer_name' => 'Senka B.',   'body' => 'Borovnice sa Ozrena su posebne — sitne ali nevjerovatnog ukusa i mirisa. Ništa slično ne može se naći u prodavnicama. Redovno naručujem.',                  'rating' => 5, 'ip_hash' => hash('sha256', '14.1.1.1')]);
        Review::create(['farmer_id' => $natasaProfile->id, 'reviewer_name' => 'Nenad V.',   'body' => 'Kupine su sočne i krupne. Džem od kupine je posebno gust i aromatičan — kupio sam 8 tegli za zimu.',                                                         'rating' => 5, 'ip_hash' => hash('sha256', '14.1.1.2')]);
        Review::create(['farmer_id' => $natasaProfile->id, 'reviewer_name' => 'Kristina M.','body' => 'Nataša je ljubazna i pedantna — pakovanje uredno, voće svježe. Džem od borovnice koristim kao namaz i u jogurt. Preporučujem svima.',                         'rating' => 5, 'ip_hash' => hash('sha256', '14.1.1.3')]);
        Review::create(['farmer_id' => $natasaProfile->id, 'reviewer_name' => 'Dragan S.',  'body' => 'Odlična ponuda šumskog voća. Jedini minus — mala količina, brzo se rasprodaje u sezoni. Vrijedi naručiti unaprijed.',                                         'rating' => 4, 'ip_hash' => hash('sha256', '14.1.1.4')]);

        // Farmer 15 — Milenko Đurić, povrće i krompir, Prijedor
        $milenko = User::create([
            'name'            => 'Milenko Đurić',
            'email'           => 'milenko.djuric@example.com',
            'password'        => Hash::make('password'),
            'role'            => 'farmer',
            'phone'           => '+38766810500',
            'viber'           => '+38766810500',
            'whatsapp'        => '+38766810500',
            'onboarding_step' => null,
        ]);

        $milenkoProfile = FarmerProfile::create([
            'user_id'     => $milenko->id,
            'farm_name'   => 'Imanje Đurić — Prijedor',
            'description' => 'Na 5 hektara posavske crnice u Ljubiji uzgajamo krompir, luk, šargarepu i cveklu. Sve sorte su provjerene i domaće — sjeme čuvamo sami već 15 godina. Bez hemije i bez vještačkih đubriva — samo stajnjak i kompost. Dostavljamo u Prijedor srijedom i subotom, veće narudžbe možemo dostavljati i u Banja Luku.',
            'city'        => 'prijedor',
            'address'     => 'Ljubija bb',
            'is_active'   => true,
        ]);

        $this->savePhoto($milenko->id, $milenkoProfile->id, 'farmer,man,vegetable,field', 126, 0);
        $this->savePhoto($milenko->id, $milenkoProfile->id, 'potato,field,harvest,farm', 132, 1, 800, 600);

        $p = Product::create(['user_id' => $milenko->id, 'category' => 'povrce', 'name' => 'Krompir crveni "Romano"',        'description' => 'Crveni krompir sorte Romano — čvrst, nisko vodeni, ne raspada se pri kuhanju. Idealan za čorbu, varivo i prilog. Kopamo u septembru i čuvamo u hladnom podrumu. Džakovi od 5, 10 ili 25 kg.', 'price' => 0.80, 'price_unit' => 'kg', 'fresh_until' => null, 'is_active' => true]);
        $this->saveProductPhoto($milenko->id, $p->id, 'potato,red,romano,harvest', 268);

        $p = Product::create(['user_id' => $milenko->id, 'category' => 'povrce', 'name' => 'Crni luk krupan',                'description' => 'Krupan domaći crni luk, čuva se do 8 mjeseci na suhom. Uzgojen bez pesticida na crnici. Idealan za kuhanje i kiseljenje. Prodajemo na komad ili u mrežama od 5 kg.', 'price' => 0.85, 'price_unit' => 'kg', 'fresh_until' => null, 'is_active' => true]);
        $this->saveProductPhoto($milenko->id, $p->id, 'onion,red,organic,farm', 269);

        $p = Product::create(['user_id' => $milenko->id, 'category' => 'povrce', 'name' => 'Bijeli luk domaći',              'description' => 'Krupan bijeli luk stare posavske sorte. Suho čuvan u pletenicama, traje do 6 mjeseci. Snažan i oštar — ideal za sve kuhane i sirove namjene. Prodajemo na komad ili pletenica (10 glavica).', 'price' => 3.50, 'price_unit' => 'kg', 'fresh_until' => null, 'is_active' => true]);
        $this->saveProductPhoto($milenko->id, $p->id, 'garlic,white,organic,braid', 270);

        $p = Product::create(['user_id' => $milenko->id, 'category' => 'povrce', 'name' => 'Šargarepa krupna svježa',        'description' => 'Krupna narančasta šargarepa, slatka i hrskava. Svježe povučena iz crnice — veća i sočnija od industrijske. Idealna za juhu, gulaš i svježe sokove. Mreže od 2 ili 5 kg.', 'price' => 0.90, 'price_unit' => 'kg', 'fresh_until' => now()->addHours(48), 'is_active' => true]);
        $this->saveProductPhoto($milenko->id, $p->id, 'carrot,fresh,orange,harvest', 271);

        $p = Product::create(['user_id' => $milenko->id, 'category' => 'povrce', 'name' => 'Cvekla (cikla) svježa',          'description' => 'Tamnocrvena cvekla bez pesticida, niska i krupna. Kuha se brzo, idealna za salate, kompote i cveklinu čorbu. Dostupna od septembra. Mreže od 1 ili 3 kg.', 'price' => 0.70, 'price_unit' => 'kg', 'fresh_until' => now()->addHours(48), 'is_active' => true]);
        $this->saveProductPhoto($milenko->id, $p->id, 'beetroot,red,organic,fresh', 272);

        Review::create(['farmer_id' => $milenkoProfile->id, 'reviewer_name' => 'Jelka P.',    'body' => 'Krompir "Romano" je savršen — ne raspada se pri kuhanju i okus je poseban. Kupujem 25 kg za zimu svake jeseni.',                                             'rating' => 5, 'ip_hash' => hash('sha256', '15.1.1.1')]);
        Review::create(['farmer_id' => $milenkoProfile->id, 'reviewer_name' => 'Mirko V.',    'body' => 'Šargarepa je slatka i hrskava — djeca je jedu i sirovu. Ništa slično nisam dobio u prodavnici. Bijeli luk odlično čuvan cijelu zimu.',                        'rating' => 5, 'ip_hash' => hash('sha256', '15.1.1.2')]);
        Review::create(['farmer_id' => $milenkoProfile->id, 'reviewer_name' => 'Radmila B.',  'body' => 'Cvekla je tamnocrvena i prirodno slatka. Napravila sam salatu i svi su pitali odakle sam nabavila. Milenko je pouzdan i tačan.',                               'rating' => 5, 'ip_hash' => hash('sha256', '15.1.1.3')]);
        Review::create(['farmer_id' => $milenkoProfile->id, 'reviewer_name' => 'Rade T.',     'body' => 'Dobra cijena za kvalitetno domaće povrće. Jedino bi trebalo organizovati dostavu i do Prijedora češće nego dvaput sedmično.',                                  'rating' => 4, 'ip_hash' => hash('sha256', '15.1.1.4')]);

        // Farmer 16 — Spasenija Vukić, kozarstvo i sirevi, Gradiška
        $spasenija = User::create([
            'name'            => 'Spasenija Vukić',
            'email'           => 'spasenija.vukic@example.com',
            'password'        => Hash::make('password'),
            'role'            => 'farmer',
            'phone'           => '+38765920600',
            'viber'           => '+38765920600',
            'whatsapp'        => null,
            'onboarding_step' => null,
        ]);

        $spasenijaProfile = FarmerProfile::create([
            'user_id'     => $spasenija->id,
            'farm_name'   => 'Kozarstvo Vukić',
            'description' => 'Na imanju kraj Save kod Gradiške uzgajam 22 koze Alpine rase — jedne od najboljih mliječnih koza na svijetu. Krave daju do 4 litre mlijeka dnevno. Od kozjeg mlijeka pravim svježi i odležani sir, jogurt i maslo po tradicionalnim receptima. Kozje mlijeko je idealnog ukusa i odlično podnosi ga i onaj ko ima problema s kravljim. Dostava u Gradišku i Banja Luku.',
            'city'        => 'gradiska',
            'address'     => 'Mačkovac bb',
            'is_active'   => true,
        ]);

        $this->savePhoto($spasenija->id, $spasenijaProfile->id, 'goat,farm,woman', 127, 0);
        $this->savePhoto($spasenija->id, $spasenijaProfile->id, 'goat,meadow,farm,alpine', 133, 1, 800, 600);

        $p = Product::create(['user_id' => $spasenija->id, 'category' => 'mlijeko', 'name' => 'Kozje mlijeko svježe (1L)',       'description' => 'Svježe pasterizirano kozje mlijeko Alpine rase. Blaži ukus od kravljeg, lako probavljivo. Idealno za djecu i osobe s intolerancijom na kravlje mlijeko. Flaša 1L, preuzimanje svako jutro.', 'price' => 2.00, 'price_unit' => 'l', 'fresh_until' => now()->addHours(24), 'is_active' => true]);
        $this->saveProductPhoto($spasenija->id, $p->id, 'goat,milk,fresh,bottle', 273);

        $p = Product::create(['user_id' => $spasenija->id, 'category' => 'mlijeko', 'name' => 'Kozji sir svježi (0,3 kg)',        'description' => 'Mekani bijeli kozji sir bez kore, kremastog ukusa i blage kiselosti. Pravi se ručno svaki dan. Odličan kao namaz na hljeb ili u salatama. Vakuumski pakovan 300g.', 'price' => 12.00, 'price_unit' => 'kg', 'fresh_until' => null, 'is_active' => true]);
        $this->saveProductPhoto($spasenija->id, $p->id, 'goat,cheese,fresh,white', 274);

        $p = Product::create(['user_id' => $spasenija->id, 'category' => 'mlijeko', 'name' => 'Kozji sir odležani (0,3 kg)',      'description' => 'Tvrdi kozji sir odležan 3 do 6 meseci u podrumu. Intenzivan, kompleksan ukus koji se razvija duljim odležavanjem. Pogodan za ribanje i uz vino. Pakovanje 300g.', 'price' => 16.00, 'price_unit' => 'kg', 'fresh_until' => null, 'is_active' => true]);
        $this->saveProductPhoto($spasenija->id, $p->id, 'goat,cheese,aged,hard', 275);

        $p = Product::create(['user_id' => $spasenija->id, 'category' => 'mlijeko', 'name' => 'Kozji jogurt (250g)',               'description' => 'Prirodno fermentovani kozji jogurt bez aditiva i stabilizatora. Kremast, blag, lako probavljiv. Idealan za doručak ili kao prilog jelima. Pakovanje 250g.', 'price' => 2.50, 'price_unit' => 'kom', 'fresh_until' => now()->addHours(48), 'is_active' => true]);
        $this->saveProductPhoto($spasenija->id, $p->id, 'goat,yogurt,fresh,dairy', 276);

        $p = Product::create(['user_id' => $spasenija->id, 'category' => 'mlijeko', 'name' => 'Kozje maslo (200g)',                'description' => 'Pravo kozje maslo bućkano od vrhnja kozjeg mlijeka. Bijele boje i blagog ukusa. Bez soli. Topi se na hljeb savršeno i daje poseban ukus pečenim jelima. Tegla 200g.', 'price' => 18.00, 'price_unit' => 'kg', 'fresh_until' => null, 'is_active' => true]);
        $this->saveProductPhoto($spasenija->id, $p->id, 'goat,butter,dairy,white', 277);

        Review::create(['farmer_id' => $spasenijaProfile->id, 'reviewer_name' => 'Vesna A.',   'body' => 'Kozje mlijeko je spasilo mog sina koji nije mogao piti kravlje. Blag ukus, ne miriše jako, djeca ga vole. Hvala Spaseniji!',                                'rating' => 5, 'ip_hash' => hash('sha256', '16.1.1.1')]);
        Review::create(['farmer_id' => $spasenijaProfile->id, 'reviewer_name' => 'Boro K.',    'body' => 'Svježi kozji sir je kremast i ukusan — kosi mi kao namaz uz domaći hljeb. Odležani sir je posebno dobar uz crveno vino.',                                   'rating' => 5, 'ip_hash' => hash('sha256', '16.1.1.2')]);
        Review::create(['farmer_id' => $spasenijaProfile->id, 'reviewer_name' => 'Anita P.',   'body' => 'Jogurt je kremast i prirodno kiseo — bez onog vještačkog ukusa iz prodavnice. Koristim ga i za torte. Spasenija je odlična domaćica.',                       'rating' => 5, 'ip_hash' => hash('sha256', '16.1.1.3')]);
        Review::create(['farmer_id' => $spasenijaProfile->id, 'reviewer_name' => 'Stanko M.',  'body' => 'Kozje maslo je bijelo i kremasto, posebnog ukusa. Dostava u Banja Luku odlična. Jedino bih volio da ima i tvrdog sira u malo većim komadima.',               'rating' => 4, 'ip_hash' => hash('sha256', '16.1.1.4')]);

        // Farmer 17 — Đorđe Petrić, žitarice i ulja, Brčko
        $djordje = User::create([
            'name'            => 'Đorđe Petrić',
            'email'           => 'djordje.petric@example.com',
            'password'        => Hash::make('password'),
            'role'            => 'farmer',
            'phone'           => '+38763430700',
            'viber'           => '+38763430700',
            'whatsapp'        => '+38763430700',
            'onboarding_step' => null,
        ]);

        $djordjeProfile = FarmerProfile::create([
            'user_id'     => $djordje->id,
            'farm_name'   => 'Polje Petrić — Brčko',
            'description' => 'Na 12 hektara brčanske ravnice uzgajam suncokret, kukuruz i pšenicu. Poseban ponos mi je hladno cijeđeno suncokretovo ulje koje pravim u vlastitoj preši — tamno, mirišljavo, kakvo se u prodavnici ne može naći. Pored ulja nudim sjemenke suncokreta za jelo i pečenje, kao i ekološki uzgojenu pšenicu za domaću pripremu. Dostava u Brčko i okolinu svaki petak.',
            'city'        => 'brcko',
            'address'     => 'Gornji Rahić bb',
            'is_active'   => true,
        ]);

        $this->savePhoto($djordje->id, $djordjeProfile->id, 'sunflower,farmer,man', 128, 0);
        $this->savePhoto($djordje->id, $djordjeProfile->id, 'sunflower,field,farm,yellow', 134, 1, 800, 600);

        $p = Product::create(['user_id' => $djordje->id, 'category' => 'ostalo',   'name' => 'Suncokretovo ulje hladno cijeđeno (1L)', 'description' => 'Hladno cijeđeno suncokretovo ulje u vlastitoj preši. Tamnoamber boje, intenzivnog mirisa suncokreta. Bez rafiniranja i hemije. Savršeno za salate i dressing. Boca 1L ili 5L.', 'price' => 7.00, 'price_unit' => 'l', 'fresh_until' => null, 'is_active' => true]);
        $this->saveProductPhoto($djordje->id, $p->id, 'sunflower,oil,cold,pressed,bottle', 278);

        $p = Product::create(['user_id' => $djordje->id, 'category' => 'zitarice', 'name' => 'Pšenica ekološka (kg)',               'description' => 'Ekološki uzgojena pšenica bez pesticida i herbicida. Idealna za klijanje, domaće brašno ili kuhanje cjelovitih žitarica. Džakovi od 5 ili 25 kg.', 'price' => 0.65, 'price_unit' => 'kg', 'fresh_until' => null, 'is_active' => true]);
        $this->saveProductPhoto($djordje->id, $p->id, 'wheat,grain,ecological,natural', 279);

        $p = Product::create(['user_id' => $djordje->id, 'category' => 'zitarice', 'name' => 'Kukuruz bijeli šećerac',               'description' => 'Slatki bijeli kukuruz šećerac, bere se mlad i sočan. Pravo za kuhanje i roštilj. Sezona jula i avgusta. Prodajemo na klip ili zrno (kilogram). Svježe beran svaki dan.', 'price' => 0.50, 'price_unit' => 'kg', 'fresh_until' => now()->addHours(24), 'is_active' => true]);
        $this->saveProductPhoto($djordje->id, $p->id, 'corn,white,sweet,fresh,cob', 280);

        $p = Product::create(['user_id' => $djordje->id, 'category' => 'ostalo',   'name' => 'Sjemenke suncokreta pržene (250g)',   'description' => 'Sjemenke suncokreta s naše njive, lako pržene na suvoj tavi bez ulja. Hrskave, prirodnog ukusa bez soli. Pakovanje 250g, idealno za grickanje i pečenje hljeba.', 'price' => 2.50, 'price_unit' => 'kom', 'fresh_until' => null, 'is_active' => true]);
        $this->saveProductPhoto($djordje->id, $p->id, 'sunflower,seeds,roasted,natural', 281);

        $p = Product::create(['user_id' => $djordje->id, 'category' => 'ostalo',   'name' => 'Bundevino sjeme za ulje (200g)',        'description' => 'Sjeme tikve bundeve, hladnoprešano za ulje ili direktno za jelo. Bogato cinkom i omega masnim kiselinama. Tamno i hrskavo. Pakovanje 200g.', 'price' => 3.00, 'price_unit' => 'kom', 'fresh_until' => null, 'is_active' => true]);
        $this->saveProductPhoto($djordje->id, $p->id, 'pumpkin,seeds,green,natural', 282);

        Review::create(['farmer_id' => $djordjeProfile->id, 'reviewer_name' => 'Tamara V.',  'body' => 'Suncokretovo ulje je tamno i mirišljavo — odmah se osjeti da je hladno cijeđeno. Salata s ovim uljem je na potpuno drugom nivou.',                           'rating' => 5, 'ip_hash' => hash('sha256', '17.1.1.1')]);
        Review::create(['farmer_id' => $djordjeProfile->id, 'reviewer_name' => 'Slađan M.',  'body' => 'Kukuruz šećerac je sočan i sladak — kuhali smo na roštilju i svi oduševljeni. Svježe beran, odmah dostavljen.',                                              'rating' => 5, 'ip_hash' => hash('sha256', '17.1.1.2')]);
        Review::create(['farmer_id' => $djordjeProfile->id, 'reviewer_name' => 'Andrijana K.','body' => 'Pržene sjemenke suncokreta su ukusne i hrskave. Koristim ih u hljeb i musli. Đorđe je tačan i uvijek pakovano uredno.',                                      'rating' => 5, 'ip_hash' => hash('sha256', '17.1.1.3')]);
        Review::create(['farmer_id' => $djordjeProfile->id, 'reviewer_name' => 'Vojin R.',   'body' => 'Ekološka pšenica za klijanje je odlična — klijanci zdravi i brzo nicaju. Ulje malo skuplje od kupovnog ali vrijednost je daleko veća.',                       'rating' => 4, 'ip_hash' => hash('sha256', '17.1.1.4')]);
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
