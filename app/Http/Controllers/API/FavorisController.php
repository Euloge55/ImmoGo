<?php
namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Favoris;
use Illuminate\Http\Request;

class FavorisController extends Controller
{
    /**
     * Ajouter aux favoris.
     * id_client est récupéré depuis auth() — plus besoin de le passer en body.
     */
    public function store(Request $request)
    {
        $request->validate([
            'id_bien' => 'required|exists:biens,id_bien',
        ]);

        $idClient = $request->user()->id_client;

        $existe = Favoris::where('id_client', $idClient)
                         ->where('id_bien', $request->id_bien)
                         ->first();

        if ($existe) {
            return response()->json(['message' => 'Bien déjà dans les favoris'], 400);
        }

        $favori = Favoris::create([
            'id_client' => $idClient,
            'id_bien'   => $request->id_bien,
        ]);

        return response()->json([
            'message' => 'Ajouté aux favoris',
            'favori'  => $favori
        ], 201);
    }

    /**
     * Liste des favoris du client connecté.
     */
    public function index(Request $request)
    {
        $idClient = $request->user()->id_client;

        $favoris = Favoris::with(['bien.agence', 'bien.typeBien', 'bien.ville', 'bien.quartier'])
                          ->where('id_client', $idClient)
                          ->get();

        return response()->json($favoris);
    }

    /**
     * Supprimer un favori par son id_favoris.
     */
    public function destroy($id)
    {
        $favori = Favoris::where('id_favoris', $id)->firstOrFail();
        $favori->delete();
        return response()->json(['message' => 'Retiré des favoris']);
    }

    /**
     * Supprimer un favori par id_bien (plus pratique côté mobile).
     */
    public function destroyByBien(Request $request, $id_bien)
    {
        $idClient = $request->user()->id_client;

        $favori = Favoris::where('id_client', $idClient)
                         ->where('id_bien', $id_bien)
                         ->firstOrFail();

        $favori->delete();
        return response()->json(['message' => 'Retiré des favoris']);
    }
}
