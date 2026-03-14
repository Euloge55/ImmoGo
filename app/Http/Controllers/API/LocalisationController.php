<?php
namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Departement;
use App\Models\Ville;
use App\Models\Quartier;
use App\Models\Bien;
use Illuminate\Http\Request;

class LocalisationController extends Controller
{
    // Tous les départements du Bénin
    public function departements()
    {
        $departements = Departement::orderBy('nom_departement')->get();
        return response()->json($departements);
    }

    // Villes d'un département
    public function villes($id_departement)
    {
        $villes = Ville::where('id_departement', $id_departement)
                       ->orderBy('nom_ville')
                       ->get();
        return response()->json($villes);
    }

    // Quartiers d'une ville
    public function quartiers($id_ville)
    {
        $quartiers = Quartier::where('id_ville', $id_ville)
                             ->orderBy('nom_quartier')
                             ->get();
        return response()->json($quartiers);
    }

    // Biens par localisation avec tri
    // Les biens disponibles en premier puis les autres
    public function biensByLocalisation(Request $request)
    {
        $query = Bien::with(['typeBien', 'agence', 'departement', 'ville', 'quartier']);

        // Filtres localisation
        if ($request->has('id_departement')) {
            $query->where('id_departement', $request->id_departement);
        }
        if ($request->has('id_ville')) {
            $query->where('id_ville', $request->id_ville);
        }
        if ($request->has('id_quartier')) {
            $query->where('id_quartier', $request->id_quartier);
        }

        // Filtres supplémentaires
        if ($request->has('id_typebien')) {
            $query->where('id_typebien', $request->id_typebien);
        }
        if ($request->has('prix_min')) {
            $query->where('prix', '>=', $request->prix_min);
        }
        if ($request->has('prix_max')) {
            $query->where('prix', '<=', $request->prix_max);
        }

        // Tri par prix
        if ($request->has('tri_prix')) {
            $query->orderBy('prix', $request->tri_prix); // asc ou desc
        }

        // Les biens DISPONIBLES en premier puis les autres
        $query->orderByRaw("FIELD(statut, 'disponible', 'reserve', 'loue', 'vendu')");

        $biens = $query->get();

        return response()->json([
            'total'  => $biens->count(),
            'biens'  => $biens
        ]);
    }

    // Recherche globale
    public function recherche(Request $request)
    {
        $query = Bien::with(['typeBien', 'agence', 'departement', 'ville', 'quartier']);

        // Recherche par mot clé
        if ($request->has('q')) {
            $query->where(function($q) use ($request) {
                $q->where('titre_bien', 'like', '%' . $request->q . '%')
                  ->orWhere('description_bien', 'like', '%' . $request->q . '%')
                  ->orWhere('localisation', 'like', '%' . $request->q . '%');
            });
        }

        // Filtre département
        if ($request->has('id_departement')) {
            $query->where('id_departement', $request->id_departement);
        }

        // Filtre ville
        if ($request->has('id_ville')) {
            $query->where('id_ville', $request->id_ville);
        }

        // Filtre quartier
        if ($request->has('id_quartier')) {
            $query->where('id_quartier', $request->id_quartier);
        }

        // Filtre type bien
        if ($request->has('id_typebien')) {
            $query->where('id_typebien', $request->id_typebien);
        }

        // Filtre prix
        if ($request->has('prix_min')) {
            $query->where('prix', '>=', $request->prix_min);
        }
        if ($request->has('prix_max')) {
            $query->where('prix', '<=', $request->prix_max);
        }

        // Filtre statut
        if ($request->has('statut')) {
            $query->where('statut', $request->statut);
        }

        // Tri
        if ($request->has('tri_prix')) {
            $query->orderBy('prix', $request->tri_prix);
        }

        // Disponibles en premier
        $query->orderByRaw("FIELD(statut, 'disponible', 'reserve', 'loue', 'vendu')");

        $biens = $query->get();

        return response()->json([
            'total' => $biens->count(),
            'biens' => $biens
        ]);
    }
}