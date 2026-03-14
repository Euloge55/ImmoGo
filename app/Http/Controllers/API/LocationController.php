<?php
namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Location;
use Illuminate\Http\Request;

class LocationController extends Controller
{
    // Détail d'une location
    public function show($id)
    {
        $location = Location::with(['contrat.client', 'contrat.bien'])
                            ->where('id_location', $id)
                            ->firstOrFail();
        return response()->json($location);
    }

    // Liste des locations d'une agence
    public function locationAgence($id_agence)
    {
        $locations = Location::with(['contrat.client', 'contrat.bien'])
                             ->whereHas('contrat.bien', function ($q) use ($id_agence) {
                                 $q->where('id_agence', $id_agence);
                             })->get();
        return response()->json($locations);
    }

    // Liste des locations d'un client
    public function locationClient($id_client)
    {
        $locations = Location::with(['contrat.bien.agence'])
                             ->whereHas('contrat', function ($q) use ($id_client) {
                                 $q->where('id_client', $id_client);
                             })->get();
        return response()->json($locations);
    }

    // Modifier une location
    public function update(Request $request, $id)
    {
        $location = Location::where('id_location', $id)->firstOrFail();

        $request->validate([
            'montant_total_location'    => 'sometimes|numeric',
            'date_reserv_location'      => 'sometimes|date',
            'date_limite_solde_location'=> 'sometimes|date',
        ]);

        $location->update($request->all());

        return response()->json([
            'message'  => 'Location modifiée avec succès',
            'location' => $location
        ]);
    }
}