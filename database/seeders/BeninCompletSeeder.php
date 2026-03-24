<?php
namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class BeninCompletSeeder extends Seeder
{
    public function run(): void
    {
        // Vider les tables d'abord
        DB::statement('SET FOREIGN_KEY_CHECKS=0');
        DB::table('quartiers')->truncate();
        DB::table('villes')->truncate();
        DB::table('departements')->truncate();
        DB::statement('SET FOREIGN_KEY_CHECKS=1');

        $data = [
            // ═══════════════════════════════════
            // 1. ALIBORI
            // ═══════════════════════════════════
            'Alibori' => [
                'Kandi' => [
                    'Kandi Centre', 'Saah', 'Kassakou', 'Donwari',
                    'Pédarou', 'Angaradébou', 'Sokontindji',
                    'Bensékou', 'Libantè', 'Sori'
                ],
                'Banikoara' => [
                    'Banikoara Centre', 'Goumori', 'Gomparou',
                    'Soroko', 'Kokey', 'Ounet', 'Founougo',
                    'Toura', 'Gomboro', 'Bagou'
                ],
                'Gogounou' => [
                    'Gogounou Centre', 'Sori', 'Zougou-Pantrossi',
                    'Gounri', 'Boutou', 'Sompérékou',
                    'Wari-Maro', 'Basso', 'Kalalé', 'Korobata'
                ],
                'Karimama' => [
                    'Karimama Centre', 'Birni-Lafia', 'Bogo-Bogo',
                    'Monsey', 'Kompa', 'Bekkeri',
                    'Guelee', 'Sota', 'Féwou', 'Bembéréké'
                ],
                'Malanville' => [
                    'Malanville Centre', 'Guène', 'Madécali',
                    'Tomboutou', 'Garou', 'Momkassa',
                    'Toumbou', 'Galiel', 'Banizoumbou', 'Dédougou'
                ],
            ],

            // ═══════════════════════════════════
            // 2. ATACORA
            // ═══════════════════════════════════
            'Atacora' => [
                'Natitingou' => [
                    'Natitingou Centre', 'Perma', 'Tchoumi-Tchoumi',
                    'Kouaba', 'Berekely', 'Firou',
                    'Toucountouna', 'Porga', 'Kounandé', 'Taïacou'
                ],
                'Tanguiéta' => [
                    'Tanguiéta Centre', 'Copargo', 'Batia',
                    'Tampégré', 'Kotopounga', 'Nambéga',
                    'Tanougou', 'Waaba', 'Fô-Bouré', 'Dassari'
                ],
                'Boukoumbé' => [
                    'Boukoumbé Centre', 'Dipoli', 'Tabota',
                    'Korontière', 'Manta', 'Kounangou',
                    'Kérou', 'Natta', 'Tchatchou', 'Nanébou'
                ],
                'Péhunco' => [
                    'Péhunco Centre', 'Gnémasson', 'Sèkèrè',
                    'Tobré', 'Fô-Tancè', 'Wantèrou',
                    'Kaobagou', 'Sinaou', 'Basso', 'Ourèga'
                ],
                'Kouandé' => [
                    'Kouandé Centre', 'Guilmaro', 'Birni',
                    'Fô-Bouré', 'Ouassa-Pehunco', 'Gonri',
                    'Kadowari', 'Panié', 'Tchatchou', 'Basso'
                ],
            ],

            // ═══════════════════════════════════
            // 3. ATLANTIQUE
            // ═══════════════════════════════════
            'Atlantique' => [
                'Abomey-Calavi' => [
                    'Abomey-Calavi Centre', 'Godomey', 'Akassato',
                    'Togba', 'Zinvié', 'Agamandin',
                    'Houedo', 'Ayichéji', 'Zogbajè', 'Womey'
                ],
                'Ouidah' => [
                    'Ouidah Centre', 'Pahou', 'Savi',
                    'Avlékété', 'Kpomassè', 'Djègbadji',
                    'Houakpè-Daho', 'Séhoué', 'Kindonou', 'Loumbou-Loumbou'
                ],
                'Allada' => [
                    'Allada Centre', 'Togoudo', 'Attogon',
                    'Sékou', 'Lissèzoun', 'Kpanroun',
                    'Agbanou', 'Zè', 'Hlassamè', 'Tokpa-Domè'
                ],
                'Toffo' => [
                    'Toffo Centre', 'Agonlin-Lowé', 'Coussi',
                    'Damè-Wogon', 'Kpomè', 'Tsrékanmè',
                    'Ahomadégbé', 'Lissazounmè', 'Djigbé', 'Houègbo'
                ],
                'Kpomassè' => [
                    'Kpomassè Centre', 'Aïzè', 'Ahozon',
                    'Pahou', 'Godomey-Sud', 'Sèdji',
                    'Tokpa', 'Avlo', 'Hinvi', 'Gakpé'
                ],
            ],

            // ═══════════════════════════════════
            // 4. BORGOU
            // ═══════════════════════════════════
            'Borgou' => [
                'Parakou' => [
                    'Parakou Centre', 'Zongo', 'Banikanni',
                    'Madina', 'Albarika', 'Douroube',
                    'Tourou', 'Kpébié', 'Guéma', 'Ladji-Bata'
                ],
                'N\'Dali' => [
                    'N\'Dali Centre', 'Bori', 'Gbégourou',
                    'Sirarou', 'Pèrèrè', 'Bembéréké',
                    'Gomparou', 'Kika', 'Tchatchou', 'Péonga'
                ],
                'Tchaourou' => [
                    'Tchaourou Centre', 'Bétérou', 'Kika',
                    'Sanson', 'Goro', 'Alafiarou',
                    'Bèrèkè', 'Worogui', 'Monrovia', 'Yèrèmarou'
                ],
                'Nikki' => [
                    'Nikki Centre', 'Biro', 'Suya',
                    'Garga', 'Tasso', 'Sérékalé',
                    'Ououbou', 'Sinaou', 'Yerimaro', 'Borgou-Koiré'
                ],
                'Pèrèrè' => [
                    'Pèrèrè Centre', 'Guinagourou', 'Gbégourou',
                    'Mondji', 'Dompago', 'Okpara',
                    'Kalalé', 'Bori', 'Sirarou', 'Dèrè'
                ],
            ],

            // ═══════════════════════════════════
            // 5. COLLINES
            // ═══════════════════════════════════
            'Collines' => [
                'Dassa-Zoumè' => [
                    'Dassa Centre', 'Soclogbo', 'Kèrè',
                    'Glazoué', 'Thio', 'Lahotan',
                    'Paouignan', 'Aklampa', 'Kpingni', 'Lèma'
                ],
                'Savalou' => [
                    'Savalou Centre', 'Monkpa', 'Doumè',
                    'Gobé', 'Lèma', 'Agbado',
                    'Kpataba', 'Ottola', 'Tchetti', 'Djaloukou'
                ],
                'Bantè' => [
                    'Bantè Centre', 'Aklankpa', 'Challa-Ogoï',
                    'Kilibo', 'Kaboua', 'Ouèssè',
                    'Alafiarou', 'Ikpinlè', 'Sèmèrè', 'Gbanlin'
                ],
                'Glazoué' => [
                    'Glazoué Centre', 'Sokponta', 'Ouèdèmè',
                    'Magoumi', 'Atokolibè', 'Zaffé',
                    'Assanté', 'Bèsson', 'Gomé', 'Thio'
                ],
                'Savè' => [
                    'Savè Centre', 'Toui', 'Ouari',
                    'Kaboua', 'Djabata', 'Okpara',
                    'Igbodja', 'Kèkèrè', 'Ottola', 'Bèsson'
                ],
            ],

            // ═══════════════════════════════════
            // 6. COUFFO
            // ═══════════════════════════════════
            'Couffo' => [
                'Aplahoué' => [
                    'Aplahoué Centre', 'Djakotomè', 'Lalo',
                    'Klouékanmè', 'Toviklin', 'Azovè',
                    'Gohomey', 'Légbassito', 'Dokonou', 'Hondjin'
                ],
                'Dogbo' => [
                    'Dogbo Centre', 'Madjrè', 'Tossoè',
                    'Fandji', 'Kpoba', 'Houédogli',
                    'Azovè', 'Gbakpodji', 'Kpinnou', 'Avèmè'
                ],
                'Klouékanmè' => [
                    'Klouékanmè Centre', 'Houéyogbé', 'Adjahonmè',
                    'Agondji', 'Sokouhoué', 'Dévé',
                    'Gohomey', 'Hondjin', 'Lalo', 'Gbakpodji'
                ],
                'Lalo' => [
                    'Lalo Centre', 'Aïdoté', 'Zalli',
                    'Gnizounmè', 'Hlassamè', 'Yokpo',
                    'Kpodji', 'Assomè', 'Toviklin', 'Djakotomè'
                ],
                'Toviklin' => [
                    'Toviklin Centre', 'Adjahonmè', 'Dévé',
                    'Houéyogbé', 'Sokouhoué', 'Kpodji',
                    'Agondji', 'Gbakpodji', 'Yokpo', 'Hondjin'
                ],
            ],

            // ═══════════════════════════════════
            // 7. DONGA
            // ═══════════════════════════════════
            'Donga' => [
                'Djougou' => [
                    'Djougou Centre', 'Barienou', 'Pédarou',
                    'Kolokondé', 'Partago', 'Bariénou',
                    'Sérou', 'Onklou', 'Pélébina', 'Barei'
                ],
                'Bassila' => [
                    'Bassila Centre', 'Manigri', 'Pénéssoulou',
                    'Tchakalakou', 'Kpésou', 'Igbèrè',
                    'Alédjo', 'Kodowari', 'Kika', 'Dèrè'
                ],
                'Copargo' => [
                    'Copargo Centre', 'Kpingni', 'Niantinitou',
                    'Nagayilé', 'Komdè', 'Bariénou',
                    'Partago', 'Barei', 'Sérou', 'Pélébina'
                ],
                'Ouaké' => [
                    'Ouaké Centre', 'Kokoro', 'Tchalinga',
                    'Sèmèrè', 'Alédjo', 'Nèkètè',
                    'Pénéssoulou', 'Kodowari', 'Igbèrè', 'Kika'
                ],
                'Tchaourou-Donga' => [
                    'Tchaourou-Donga Centre', 'Partago', 'Onklou',
                    'Pélébina', 'Sérou', 'Bariénou',
                    'Kolokondé', 'Kpésou', 'Nagayilé', 'Komdè'
                ],
            ],

            // ═══════════════════════════════════
            // 8. LITTORAL
            // ═══════════════════════════════════
            'Littoral' => [
                'Cotonou' => [
                    'Akpakpa', 'Cadjehoun', 'Gbèdjromèdo',
                    'Godomey-Est', 'Haie-Vive', 'Jéricho',
                    'Mènontin', 'Missèbo', 'Sainte-Rita', 'Zogbo'
                ],
                'Cotonou-Nord' => [
                    'Agla', 'Aïbatin', 'Cocotiers',
                    'Fidjrossè', 'Houeyiho', 'Kpondéhou',
                    'Ladji', 'Modjègan', 'PK3', 'Wologuèdè'
                ],
                'Cotonou-Est' => [
                    'Aïdjèdo', 'Dantokpa', 'Gbèkon',
                    'Kindonou', 'Kowégbo', 'Millenium',
                    'Sènadé', 'Tokpa', 'Vodjè', 'Zongo'
                ],
                'Cotonou-Ouest' => [
                    'Abattoir', 'Cotonou-Port', 'Gbodjicodji',
                    'Maison-Rouge', 'Placodji', 'Saint-Michel',
                    'Sikècodji', 'Tokplégbé', 'Vossa', 'Xwlacodji'
                ],
                'Cotonou-Centre' => [
                    'Ganhi', 'Gbégamey', 'Jonquet',
                    'Kouhounou', 'Lèmè', 'Minontinssi',
                    'Place-Bulgarie', 'Sainte-Cécile', 'Vedoko', 'Zongo-Carré'
                ],
            ],

            // ═══════════════════════════════════
            // 9. MONO
            // ═══════════════════════════════════
            'Mono' => [
                'Lokossa' => [
                    'Lokossa Centre', 'Houin', 'Agamè',
                    'Koudo', 'Possotomè', 'Dogbo-Tota',
                    'Kpinnou', 'Avèmè', 'Adjohoun', 'Tokpa-Domè'
                ],
                'Athiémé' => [
                    'Athiémé Centre', 'Agatogbo', 'Dekin',
                    'Lobogo', 'Djanglanmè', 'Tokpa',
                    'Koudo', 'Houin', 'Agamè', 'Gbèkon'
                ],
                'Bopa' => [
                    'Bopa Centre', 'Gbéhoué', 'Agbodji',
                    'Possotomè', 'Gbakpodji', 'Honnoukoué',
                    'Dèdjanou', 'Aïzè', 'Tokpa', 'Avlokè'
                ],
                'Comè' => [
                    'Comè Centre', 'Ouèdèmè-Pédah', 'Dèdjanou',
                    'Djègbadji', 'Avlokè', 'Gbèkon',
                    'Tokpa', 'Aïzè', 'Bopa', 'Houéyogbé'
                ],
                'Grand-Popo' => [
                    'Grand-Popo Centre', 'Agoué', 'Avlo',
                    'Djanglanmè', 'Gbèkon', 'Hèvè',
                    'Hillacondji', 'Sazué', 'Tokpa', 'Xwéfa'
                ],
            ],

            // ═══════════════════════════════════
            // 10. OUÉMÉ
            // ═══════════════════════════════════
            'Ouémé' => [
                'Porto-Novo' => [
                    'Ouando', 'Agboville', 'Attaké',
                    'Djassin', 'Ekpè', 'Gbèto',
                    'Houinmè', 'Kodé', 'Tokpota', 'Vossa'
                ],
                'Adjarra' => [
                    'Adjarra Centre', 'Daagbé', 'Hèvié',
                    'Intchèdji', 'Kètou', 'Onigbolo',
                    'Sakété', 'Tchatchou', 'Tokpa', 'Zoungbomè'
                ],
                'Akpro-Missérété' => [
                    'Akpro-Missérété Centre', 'Dékanmè', 'Gbèto',
                    'Houédogli', 'Igolo', 'Kodé',
                    'Missérété', 'Pahou', 'Togba', 'Zoungbomè'
                ],
                'Avrankou' => [
                    'Avrankou Centre', 'Adjohoun', 'Agbovi',
                    'Daagbé', 'Gangban', 'Houinmè',
                    'Kodé', 'Odjaï', 'Ségbana', 'Vèkky'
                ],
                'Bonou' => [
                    'Bonou Centre', 'Affamè', 'Dèkpo',
                    'Gangban', 'Gbèdji', 'Hlacodji',
                    'Massè', 'Odjaï', 'Sèmè-Kpodji', 'Vèkky'
                ],
            ],

            // ═══════════════════════════════════
            // 11. PLATEAU
            // ═══════════════════════════════════
            'Plateau' => [
                'Pobè' => [
                    'Pobè Centre', 'Igana', 'Issaba',
                    'Kpankou', 'Lèma', 'Onigbolo',
                    'Ègba', 'Kétou', 'Adja-Ouèrè', 'Idigny'
                ],
                'Kétou' => [
                    'Kétou Centre', 'Adakplamè', 'Idigny',
                    'Okpomèta', 'Odomèta', 'Tchetti',
                    'Lèma', 'Issaba', 'Igana', 'Onigbolo'
                ],
                'Adja-Ouèrè' => [
                    'Adja-Ouèrè Centre', 'Daffo', 'Kpari',
                    'Onikèkè', 'Daagbé', 'Odjaï',
                    'Kpankou', 'Issaba', 'Igana', 'Idigny'
                ],
                'Ifangni' => [
                    'Ifangni Centre', 'Ikpinlè', 'Kpoulou',
                    'Ègba', 'Issaba', 'Lèma',
                    'Onigbolo', 'Pobè', 'Sakété', 'Tchatchou'
                ],
                'Sakété' => [
                    'Sakété Centre', 'Adjarra', 'Daagbé',
                    'Gangban', 'Gbodjo', 'Houèdomè',
                    'Igolo', 'Kpankou', 'Odjaï', 'Zoungbomè'
                ],
            ],

            // ═══════════════════════════════════
            // 12. ZOU
            // ═══════════════════════════════════
            'Zou' => [
                'Abomey' => [
                    'Abomey Centre', 'Agbokpa', 'Détohou',
                    'Djègbé', 'Gnizounmè', 'Hounli',
                    'Kpakpamè', 'Sèhouè', 'Vidolé', 'Zounzonmè'
                ],
                'Bohicon' => [
                    'Bohicon Centre', 'Ahozon', 'Avogbana',
                    'Gnidjazoun', 'Hounli', 'Lissèzoun',
                    'Passagon', 'Saclo', 'Sodohomè', 'Zounzonmè'
                ],
                'Covè' => [
                    'Covè Centre', 'Domè', 'Gbèdjromèdo',
                    'Kpinnou', 'Lèma', 'Ouèssè',
                    'Sèhouè', 'Tohoués', 'Zagnanado', 'Zounzonmè'
                ],
                'Agbangnizoun' => [
                    'Agbangnizoun Centre', 'Cové', 'Djidja',
                    'Kpakpamè', 'Ouinhi', 'Sèhouè',
                    'Vidolé', 'Zounzonmè', 'Gbèdjromèdo', 'Tohoués'
                ],
                'Zagnanado' => [
                    'Zagnanado Centre', 'Covè', 'Domè',
                    'Kpinnou', 'Ouinhi', 'Sèhouè',
                    'Tohoués', 'Vidolé', 'Zounzonmè', 'Lèma'
                ],
            ],
        ];

        foreach ($data as $nomDep => $villes) {
            $depId = DB::table('departements')->insertGetId([
                'nom_departement' => $nomDep,
                'created_at'      => now(),
                'updated_at'      => now(),
            ]);

            foreach ($villes as $nomVille => $quartiers) {
                $villeId = DB::table('villes')->insertGetId([
                    'id_departement' => $depId,
                    'nom_ville'      => $nomVille,
                    'created_at'     => now(),
                    'updated_at'     => now(),
                ]);

                foreach ($quartiers as $nomQuartier) {
                    DB::table('quartiers')->insert([
                        'id_ville'      => $villeId,
                        'nom_quartier'  => $nomQuartier,
                        'created_at'    => now(),
                        'updated_at'    => now(),
                    ]);
                }
            }
        }

        $this->command->info('✅ ' . count($data) . ' départements créés !');
        $this->command->info('✅ ' . DB::table('villes')->count() . ' villes créées !');
        $this->command->info('✅ ' . DB::table('quartiers')->count() . ' quartiers créés !');
    }
}