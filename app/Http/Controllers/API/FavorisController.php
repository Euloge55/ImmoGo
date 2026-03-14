<?php
namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Favoris;
use Illuminate\Http\Request;

class FavorisController extends Controller
{
    // Ajouter aux favoris
    public function store(Request $request)
    {
        $request->validate([
            'id_client' => 'required|exists:clients,id_client',
            'id_bien'   => 'required|exists:biens,id_bien',
        ]);

        $existe = Favoris::where('id_client', $request->id_client)
                         ->where('id_bien', $request->id_bien)
                         ->first();

        if ($existe) {
            return response()->json(['message' => 'Bien déjà dans les favoris'], 400);
        }

        $favori = Favoris::create($request->all());
        return response()->json([
            'message' => 'Ajouté aux favoris',
            'favori'  => $favori
        ], 201);
    }

    // Liste des favoris d'un client
    public function index($id_client)
    {
        $favoris = Favoris::with('bien')
                          ->where('id_client', $id_client)
                          ->get();
        return response()->json($favoris);
    }

    // Supprimer un favori
    public function destroy($id)
    {
        $favori = Favoris::where('id_favoris', $id)->firstOrFail();
        $favori->delete();
        return response()->json(['message' => 'Retiré des favoris']);
    }
}