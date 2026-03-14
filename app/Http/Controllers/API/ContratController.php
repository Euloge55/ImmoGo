<?php
namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Contrat;
use App\Models\Bien;
use App\Models\Location;
use App\Models\Vente;
use Illuminate\Http\Request;

class ContratController extends Controller
{
    // Créer un contrat (réservation)
    public function store(Request $request)
    {
        $request->validate([
            'id_client'     => 'required|exists:clients,id_client',
            'id_bien'       => 'required|exists:biens,id_bien',
            'type_contrat'  => 'required|in:location,vente',
            'date_location' => 'nullable|date',
        ]);

        // Vérifier que le bien est disponible
        $bien = Bien::where('id_bien', $request->id_bien)->firstOrFail();
        if ($bien->statut !== 'disponible') {
            return response()->json(['message' => 'Ce bien n\'est plus disponible'], 400);
        }

        $contrat = Contrat::create([
            'id_client'      => $request->id_client,
            'id_bien'        => $request->id_bien,
            'type_contrat'   => $request->type_contrat,
            'statut_contrat' => 'en_attente',
            'date_location'  => $request->date_location,
        ]);

        // Créer location ou vente selon le type
        if ($request->type_contrat === 'location') {
            Location::create([
                'id_contrat'               => $contrat->id_contrat,
                'montant_total_location'   => $bien->prix,
                'date_reserv_location'     => now(),
                'date_limite_solde_location' => now()->addDays(7),
            ]);
        } else {
            Vente::create([
                'id_contrat'             => $contrat->id_contrat,
                'montant_total_vente'    => $bien->prix,
                'date_reserv_vente'      => now(),
                'date_limite_solde_vente' => now()->addDays(30),
            ]);
        }

        // Mettre le bien en réservé
        $bien->update(['statut' => 'reserve']);

        return response()->json([
            'message' => 'Réservation créée avec succès',
            'contrat' => $contrat->load(['location', 'vente'])
        ], 201);
    }

    // Liste des contrats d'un client
    public function contratClient($id_client)
    {
        $contrats = Contrat::with(['bien', 'location', 'vente', 'paiements'])
                           ->where('id_client', $id_client)
                           ->get();
        return response()->json($contrats);
    }

    // Liste des contrats d'une agence
    public function contratAgence($id_agence)
    {
        $contrats = Contrat::with(['bien', 'client', 'location', 'vente', 'paiements'])
                           ->whereHas('bien', function($q) use ($id_agence) {
                               $q->where('id_agence', $id_agence);
                           })->get();
        return response()->json($contrats);
    }

    // Calculer solde restant
    public function calculerSolde($id)
    {
        $contrat = Contrat::with(['paiements', 'location', 'vente'])
                          ->where('id_contrat', $id)
                          ->firstOrFail();

        $montantTotal = $contrat->type_contrat === 'location'
            ? $contrat->location->montant_total_location
            : $contrat->vente->montant_total_vente;

        $totalPaye = $contrat->paiements->sum('montant');
        $solde     = $montantTotal - $totalPaye;

        return response()->json([
            'montant_total' => $montantTotal,
            'total_paye'    => $totalPaye,
            'solde_restant' => $solde
        ]);
    }
}