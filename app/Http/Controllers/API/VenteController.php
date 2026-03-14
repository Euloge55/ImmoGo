<?php
namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Vente;
use Illuminate\Http\Request;

class VenteController extends Controller
{
    // Détail d'une vente
    public function show($id)
    {
        $vente = Vente::with(['contrat.client', 'contrat.bien'])
                      ->where('id_vente', $id)
                      ->firstOrFail();
        return response()->json($vente);
    }

    // Liste des ventes d'une agence
    public function venteAgence($id_agence)
    {
        $ventes = Vente::with(['contrat.client', 'contrat.bien'])
                       ->whereHas('contrat.bien', function ($q) use ($id_agence) {
                           $q->where('id_agence', $id_agence);
                       })->get();
        return response()->json($ventes);
    }

    // Liste des ventes d'un client
    public function venteClient($id_client)
    {
        $ventes = Vente::with(['contrat.bien.agence'])
                       ->whereHas('contrat', function ($q) use ($id_client) {
                           $q->where('id_client', $id_client);
                       })->get();
        return response()->json($ventes);
    }

    // Modifier une vente
    public function update(Request $request, $id)
    {
        $vente = Vente::where('id_vente', $id)->firstOrFail();

        $request->validate([
            'montant_total_vente'    => 'sometimes|numeric',
            'date_reserv_vente'      => 'sometimes|date',
            'date_limite_solde_vente'=> 'sometimes|date',
        ]);

        $vente->update($request->all());

        return response()->json([
            'message' => 'Vente modifiée avec succès',
            'vente'   => $vente
        ]);
    }
}