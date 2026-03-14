<?php
namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Departement;
use App\Models\Ville;
use App\Models\Quartier;

class BeninSeeder extends Seeder
{
    public function run()
    {
        // Vérifier si les données existent déjà
        if (Departement::count() > 0) {
            $this->command->info('Les données existent déjà, seeder ignoré.');
            return;
        }
        $data = [
            'Alibori' => [
                'Kandi' => ['Kandi Centre', 'Kassakou', 'Saah'],
                'Banikoara' => ['Banikoara Centre', 'Goumori'],
                'Gogounou' => ['Gogounou Centre'],
            ],
            'Atacora' => [
                'Natitingou' => ['Natitingou Centre', 'Porga', 'Toucountouna'],
                'Djougou' => ['Djougou Centre', 'Kolokondé'],
                'Tanguiéta' => ['Tanguiéta Centre'],
            ],
            'Atlantique' => [
                'Abomey-Calavi' => ['Abomey-Calavi Centre', 'Godomey', 'Akassato', 'Togba', 'Zinvié' , 'Agamandin', 'Houedo' , 'Ayichéji', 'Zogbajè'],
                'Ouidah' => ['Ouidah Centre', 'Pahou', 'Kpomassè'],
                'Allada' => ['Allada Centre', 'Sékou', 'Toffo'],
                'Cotonou' => ['Fidjrossè', 'Cadjèhoun', 'Akpakpa', 'Dantokpa', 'Agla', 'Vèdoko'],
            ],

            'Borgou' => [
                'Parakou' => ['Parakou Centre', 'Banikanni', 'Zongo', 'Albarika'],
                'Nikki' => ['Nikki Centre', 'Biro'],
                'Tchaourou' => ['Tchaourou Centre'],
            ],
            'Collines' => [
                'Savalou' => ['Savalou Centre', 'Doumè'],
                'Dassa-Zoumè' => ['Dassa Centre', 'Paouignan'],
                'Bantè' => ['Bantè Centre'],
            ],
            'Couffo' => [
                'Aplahoué' => ['Aplahoué Centre', 'Djakotomey'],
                'Klouékanmè' => ['Klouékanmè Centre'],
                'Lalo' => ['Lalo Centre'],
            ],
            'Donga' => [
                'Djougou' => ['Djougou Centre', 'Barienou'],
                'Copargo' => ['Copargo Centre'],
                'Bassila' => ['Bassila Centre'],
            ],
            'Littoral' => [
                'Cotonou' => [
                    'Akpakpa', 'Cadjèhoun', 'Fidjrossè',
                    'Agla', 'Vèdoko', 'Dantokpa',
                    'Gbèdjromèdé', 'Zogbo', 'Mènontin',
                    'Avotrou', 'Sikècodji', 'Haie Vive' ,'Gbégamè'
                ],
            ],
            'Mono' => [
                'Lokossa' => ['Lokossa Centre', 'Possotomè'],
                'Comè' => ['Comè Centre', 'Athiémé'],
                'Grand-Popo' => ['Grand-Popo Centre'],
            ],
            'Ouémé' => [
                'Porto-Novo' => [
                    'Porto-Novo Centre', 'Ouando',
                    'Agboville', 'Tokpota', 'Houinmè'
                ],
                'Sèmè-Kpodji' => ['Sèmè-Kpodji Centre', 'Agblangandan'],
                'Adjarra' => ['Adjarra Centre'],
            ],
            'Plateau' => [
                'Pobè' => ['Pobè Centre', 'Igana'],
                'Sakété' => ['Sakété Centre', 'Ifangni'],
                'Kétou' => ['Kétou Centre'],
            ],
            'Zou' => [
                'Abomey' => ['Abomey Centre', 'Bohicon', 'Agbangnizoun' ],
                'Bohicon' => ['Bohicon Centre', 'Lissèzoun'],
                'Covè' => ['Covè Centre'],
            ],
        ];

        foreach ($data as $nomDep => $villes) {
            $departement = Departement::create([
                'nom_departement' => $nomDep
            ]);

            foreach ($villes as $nomVille => $quartiers) {
                $ville = Ville::create([
                    'id_departement' => $departement->id_departement,
                    'nom_ville'      => $nomVille
                ]);

                foreach ($quartiers as $nomQuartier) {
                    Quartier::create([
                        'id_ville'      => $ville->id_ville,
                        'nom_quartier'  => $nomQuartier
                    ]);
                }
            }
        }
    }
}