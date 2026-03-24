<?php
namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Departement;
use App\Models\Ville;
use App\Models\Quartier;
use App\Models\Bien;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class LocalisationController extends Controller
{
    /**
     * GET /api/departements
     * Retourne tous les départements triés alphabétiquement.
     * Public — aucune auth requise.
     */
    public function departements()
    {
        try {
            $departements = Departement::orderBy('nom_departement')->get();
            return response()->json($departements);
        } catch (\Exception $e) {
            Log::error('Erreur departements: ' . $e->getMessage());
            return response()->json(['message' => 'Erreur serveur'], 500);
        }
    }

    /**
     * GET /api/departements/{id}/villes
     * Retourne les villes d'un département.
     */
    public function villes($id_departement)
    {
        try {
            // Vérifier que le département existe
            $dep = Departement::where('id_departement', $id_departement)->first();
            if (!$dep) {
                return response()->json(['message' => 'Département introuvable'], 404);
            }

            $villes = Ville::where('id_departement', $id_departement)
                           ->orderBy('nom_ville')
                           ->get();
            return response()->json($villes);
        } catch (\Exception $e) {
            Log::error('Erreur villes: ' . $e->getMessage());
            return response()->json(['message' => 'Erreur serveur'], 500);
        }
    }

    /**
     * GET /api/villes/{id}/quartiers
     * Retourne les quartiers d'une ville.
     */
    public function quartiers($id_ville)
    {
        try {
            $ville = Ville::where('id_ville', $id_ville)->first();
            if (!$ville) {
                return response()->json(['message' => 'Ville introuvable'], 404);
            }

            $quartiers = Quartier::where('id_ville', $id_ville)
                                 ->orderBy('nom_quartier')
                                 ->get();
            return response()->json($quartiers);
        } catch (\Exception $e) {
            Log::error('Erreur quartiers: ' . $e->getMessage());
            return response()->json(['message' => 'Erreur serveur'], 500);
        }
    }

    /**
     * GET /api/recherche
     * Recherche unifiée paginée avec filtres.
     */
    public function recherche(Request $request)
    {
        try {
            $query = Bien::with(['typeBien', 'agence', 'departement', 'ville', 'quartier']);

            if ($request->filled('q')) {
                $q = $request->q;
                $query->where(function ($sub) use ($q) {
                    $sub->where('titre_bien', 'like', "%{$q}%")
                        ->orWhere('description_bien', 'like', "%{$q}%")
                        ->orWhere('localisation', 'like', "%{$q}%");
                });
            }
            if ($request->filled('id_departement')) {
                $query->where('id_departement', $request->id_departement);
            }
            if ($request->filled('id_ville')) {
                $query->where('id_ville', $request->id_ville);
            }
            if ($request->filled('id_quartier')) {
                $query->where('id_quartier', $request->id_quartier);
            }
            if ($request->filled('id_typebien')) {
                $query->where('id_typebien', $request->id_typebien);
            }
            if ($request->filled('type_transaction')) {
                $query->where('type_transaction', $request->type_transaction);
            }
            if ($request->filled('nombre_pieces')) {
                $query->where('nombre_pieces', $request->nombre_pieces);
            }
            if ($request->filled('prix_min')) {
                $query->where('prix', '>=', $request->prix_min);
            }
            if ($request->filled('prix_max')) {
                $query->where('prix', '<=', $request->prix_max);
            }
            if ($request->filled('statut')) {
                $query->where('statut', $request->statut);
            }
            if ($request->filled('tri_prix') && in_array($request->tri_prix, ['asc', 'desc'])) {
                $query->orderBy('prix', $request->tri_prix);
            }

            $query->orderByRaw("FIELD(statut, 'disponible', 'reserve', 'loue', 'vendu')");

            $perPage = min((int) $request->get('per_page', 15), 50);
            $biens   = $query->paginate($perPage);

            return response()->json($biens);
        } catch (\Exception $e) {
            Log::error('Erreur recherche: ' . $e->getMessage());
            return response()->json(['message' => 'Erreur serveur'], 500);
        }
    }
}
