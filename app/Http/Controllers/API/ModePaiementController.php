<?php
namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\ModePaiement;
use Illuminate\Http\Request;

class ModePaiementController extends Controller
{
    // Liste des modes de paiement
    public function index()
    {
        $modes = ModePaiement::all();
        return response()->json($modes);
    }

    // Créer un mode de paiement
    public function store(Request $request)
    {
        $request->validate([
            'nom_mode_paiement' => 'required|string|unique:mode_paiements,nom_mode_paiement'
        ]);

        $mode = ModePaiement::create($request->all());

        return response()->json([
            'message' => 'Mode de paiement créé avec succès',
            'mode'    => $mode
        ], 201);
    }

    // Modifier un mode de paiement
    public function update(Request $request, $id)
    {
        $mode = ModePaiement::where('id_mode_paiement', $id)->firstOrFail();

        $request->validate([
            'nom_mode_paiement' => 'required|string|unique:mode_paiements,nom_mode_paiement,' . $id . ',id_mode_paiement'
        ]);

        $mode->update($request->all());

        return response()->json([
            'message' => 'Mode de paiement modifié avec succès',
            'mode'    => $mode
        ]);
    }

    // Supprimer un mode de paiement
    public function destroy($id)
    {
        ModePaiement::where('id_mode_paiement', $id)->firstOrFail()->delete();
        return response()->json([
            'message' => 'Mode de paiement supprimé avec succès'
        ]);
    }
}