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
