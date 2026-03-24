<?php
namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Bien;
use Illuminate\Http\Request;

class BienController extends Controller
{
    /**
     * Liste paginée des biens (public).
     * Filtres : statut, id_typebien, prix_max, nombre_pieces, type_transaction
     * type_transaction : 'location' | 'vente' (déduit du champ type_transaction du bien)
     */
    public function index(Request $request)
    {
        $query = Bien::with(['agence', 'typeBien', 'departement', 'ville', 'quartier']);

        if ($request->filled('statut')) {
            $query->where('statut', $request->statut);
        }
        if ($request->filled('id_typebien')) {
            $query->where('id_typebien', $request->id_typebien);
        }
        if ($request->filled('prix_max')) {
            $query->where('prix', '<=', $request->prix_max);
        }
        if ($request->filled('prix_min')) {
            $query->where('prix', '>=', $request->prix_min);
        }
        if ($request->filled('nombre_pieces')) {
            $query->where('nombre_pieces', $request->nombre_pieces);
        }
        if ($request->filled('type_transaction')) {
            $query->where('type_transaction', $request->type_transaction);
        }

        // Disponibles en premier
        $query->orderByRaw("FIELD(statut, 'disponible', 'reserve', 'loue', 'vendu')");

        $perPage = min((int) $request->get('per_page', 15), 50);
        $biens   = $query->paginate($perPage);

        return response()->json($biens);
    }

    /**
     * Détail d'un bien.
     */
    public function show($id)
    {
        $bien = Bien::with(['agence', 'typeBien', 'administrateur', 'departement', 'ville', 'quartier'])
                    ->where('id_bien', $id)
                    ->firstOrFail();
        return response()->json($bien);
    }

    /**
     * Créer un bien (admin).
     */
    public function store(Request $request)
    {
        $request->validate([
            'id_agence'        => 'required|exists:agences,id_agence',
            'id_admin'         => 'required|exists:administrateurs,id_admin',
            'id_typebien'      => 'required|exists:type_biens,id_typebien',
            'titre_bien'       => 'required|string|max:255',
            'description_bien' => 'required|string',
            'prix'             => 'required|numeric|min:0',
            'superficie'       => 'required|numeric|min:0',
            'localisation'     => 'required|string',
            'type_transaction' => 'required|in:location,vente',
            'nombre_pieces'    => 'nullable|integer|min:0',
            'nombre_salles_bain'=> 'nullable|integer|min:0',
            'photos'           => 'nullable|array',
            'id_departement'   => 'nullable|exists:departements,id_departement',
            'id_ville'         => 'nullable|exists:villes,id_ville',
            'id_quartier'      => 'nullable|exists:quartiers,id_quartier',
        ]);

        $bien = Bien::create($request->all());

        return response()->json([
            'message' => 'Bien créé avec succès',
            'bien'    => $bien
        ], 201);
    }

    /**
     * Modifier un bien (admin).
     */
    public function update(Request $request, $id)
    {
        $bien = Bien::where('id_bien', $id)->firstOrFail();
        $bien->update($request->all());
        return response()->json([
            'message' => 'Bien modifié avec succès',
            'bien'    => $bien
        ]);
    }

    /**
     * Modifier le statut d'un bien (admin).
     */
    public function modifierStatut(Request $request, $id)
    {
        $request->validate([
            'statut' => 'required|in:disponible,reserve,loue,vendu'
        ]);
        $bien = Bien::where('id_bien', $id)->firstOrFail();
        $bien->update(['statut' => $request->statut]);
        return response()->json([
            'message' => 'Statut modifié avec succès',
            'bien'    => $bien
        ]);
    }

    /**
     * Supprimer un bien (admin).
     */
    public function destroy($id)
    {
        $bien = Bien::where('id_bien', $id)->firstOrFail();
        $bien->delete();
        return response()->json(['message' => 'Bien supprimé avec succès']);
    }
}
