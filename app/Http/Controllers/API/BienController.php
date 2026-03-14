<?php
namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Bien;
use Illuminate\Http\Request;

class BienController extends Controller
{
    // Liste tous les biens (visiteur)
    public function index(Request $request)
    {
        $query = Bien::with(['agence', 'typeBien']);

        if ($request->has('statut')) {
            $query->where('statut', $request->statut);
        }
        if ($request->has('localisation')) {
            $query->where('localisation', 'like', '%' . $request->localisation . '%');
        }
        if ($request->has('prix_max')) {
            $query->where('prix', '<=', $request->prix_max);
        }
        if ($request->has('id_typebien')) {
            $query->where('id_typebien', $request->id_typebien);
        }

        return response()->json($query->get());
    }

    // Détail d'un bien
    public function show($id)
    {
        $bien = Bien::with(['agence', 'typeBien', 'administrateur'])
                    ->where('id_bien', $id)
                    ->firstOrFail();
        return response()->json($bien);
    }

    // Créer un bien (admin)
    public function store(Request $request)
    {
        $request->validate([
            'id_agence'       => 'required|exists:agences,id_agence',
            'id_admin'        => 'required|exists:administrateurs,id_admin',
            'id_typebien'     => 'required|exists:type_biens,id_typebien',
            'titre_bien'      => 'required|string',
            'description_bien'=> 'required|string',
            'prix'            => 'required|numeric',
            'superficie'      => 'required|numeric',
            'localisation'    => 'required|string',
            'photos'          => 'nullable|array',
        ]);

        $bien = Bien::create($request->all());

        return response()->json([
            'message' => 'Bien créé avec succès',
            'bien'    => $bien
        ], 201);
    }

    // Modifier un bien
    public function update(Request $request, $id)
    {
        $bien = Bien::where('id_bien', $id)->firstOrFail();
        $bien->update($request->all());
        return response()->json([
            'message' => 'Bien modifié avec succès',
            'bien'    => $bien
        ]);
    }

    // Modifier statut d'un bien
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

    // Supprimer un bien
    public function destroy($id)
    {
        $bien = Bien::where('id_bien', $id)->firstOrFail();
        $bien->delete();
        return response()->json(['message' => 'Bien supprimé avec succès']);
    }
}