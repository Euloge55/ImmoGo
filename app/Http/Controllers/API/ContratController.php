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
    /**
     * Créer un contrat (réservation).
     * id_client est récupéré depuis auth() — sécurisé contre la falsification.
     */
    public function store(Request $request)
    {
        $request->validate([
            'id_bien'       => 'required|exists:biens,id_bien',
            'type_contrat'  => 'required|in:location,vente',
            'date_location' => 'nullable|date',
        ]);

        $idClient = $request->user()->id_client;

        $bien = Bien::where('id_bien', $request->id_bien)->firstOrFail();

        if ($bien->statut !== 'disponible') {
            return response()->json(['message' => 'Ce bien n\'est plus disponible'], 400);
        }

        // Vérifier cohérence type_contrat / type_transaction du bien
        if ($bien->type_transaction && $bien->type_transaction !== $request->type_contrat) {
            return response()->json([
                'message' => 'Ce bien n\'est pas disponible pour ce type de transaction'
            ], 400);
        }

        $contrat = Contrat::create([
            'id_client'      => $idClient,
            'id_bien'        => $request->id_bien,
            'type_contrat'   => $request->type_contrat,
            'statut_contrat' => 'en_attente',
            'date_location'  => $request->date_location,
        ]);

        if ($request->type_contrat === 'location') {
            Location::create([
                'id_contrat'                 => $contrat->id_contrat,
                'montant_total_location'     => $bien->prix,
                'date_reserv_location'       => now(),
                'date_limite_solde_location' => now()->addDays(7),
            ]);
        } else {
            Vente::create([
                'id_contrat'              => $contrat->id_contrat,
                'montant_total_vente'     => $bien->prix,
                'date_reserv_vente'       => now(),
                'date_limite_solde_vente' => now()->addDays(30),
            ]);
        }

        $bien->update(['statut' => 'reserve']);

        return response()->json([
            'message' => 'Réservation créée avec succès',
            'contrat' => $contrat->load(['location', 'vente', 'bien'])
        ], 201);
    }

    /**
     * Liste des contrats du client connecté (GET /contrats).
     */
    public function contratClient(Request $request)
    {
        $idClient = $request->user()->id_client;

        $contrats = Contrat::with(['bien.agence', 'bien.ville', 'location', 'vente', 'paiements'])
                           ->where('id_client', $idClient)
                           ->latest()
                           ->get();

        return response()->json($contrats);
    }

    /**
     * Liste des contrats d'une agence (admin).
     */
    public function contratAgence($id_agence)
    {
        $contrats = Contrat::with(['bien', 'client', 'location', 'vente', 'paiements'])
                           ->whereHas('bien', fn($q) => $q->where('id_agence', $id_agence))
                           ->latest()
                           ->get();

        return response()->json($contrats);
    }

    /**
     * Calculer le solde restant d'un contrat.
     */
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
            'montant_total'  => $montantTotal,
            'total_paye'     => $totalPaye,
            'solde_restant'  => $solde,
            'date_limite'    => $contrat->type_contrat === 'location'
                ? $contrat->location->date_limite_solde_location
                : $contrat->vente->date_limite_solde_vente,
        ]);
    }
}
