<?php
namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Paiement;
use App\Models\Contrat;
use App\Models\Bien;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class PaiementController extends Controller
{
    // Effectuer un paiement
    public function store(Request $request)
    {
        $request->validate([
            'id_contrat'      => 'required|exists:contrats,id_contrat',
            'id_mode_paiement'=> 'required|exists:mode_paiements,id_mode_paiement',
            'montant'         => 'required|numeric|min:1',
            'type_paiement'   => 'required|in:acompte,solde,complet',
        ]);

        $contrat = Contrat::with(['paiements', 'location', 'vente', 'bien'])
                          ->where('id_contrat', $request->id_contrat)
                          ->firstOrFail();

        $montantTotal = $contrat->type_contrat === 'location'
            ? $contrat->location->montant_total_location
            : $contrat->vente->montant_total_vente;

        // Calcul acompte 10%
        $acompte = $montantTotal * 0.10;

        if ($request->type_paiement === 'acompte' && $request->montant < $acompte) {
            return response()->json([
                'message' => 'L\'acompte minimum est de ' . $acompte
            ], 400);
        }

        $paiement = Paiement::create([
            'id_contrat'       => $request->id_contrat,
            'id_mode_paiement' => $request->id_mode_paiement,
            'montant'          => $request->montant,
            'date_paiement'    => now(),
            'type_paiement'    => $request->type_paiement,
            'reference'        => 'PAY-' . strtoupper(Str::random(10)),
        ]);

        // Vérifier si tout est payé
        $totalPaye = $contrat->paiements->sum('montant') + $request->montant;
        if ($totalPaye >= $montantTotal) {
            $contrat->update(['statut_contrat' => 'confirme']);
            $statut = $contrat->type_contrat === 'location' ? 'loue' : 'vendu';
            $contrat->bien->update(['statut' => $statut]);
        }

        return response()->json([
            'message'   => 'Paiement effectué avec succès',
            'paiement'  => $paiement,
            'reference' => $paiement->reference
        ], 201);
    }

    // Historique paiements d'un contrat
    public function historique($id_contrat)
    {
        $paiements = Paiement::with('modePaiement')
                             ->where('id_contrat', $id_contrat)
                             ->get();
        return response()->json($paiements);
    }
}