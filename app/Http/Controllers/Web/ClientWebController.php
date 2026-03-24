<?php
namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\Client;
use App\Models\Contrat;
use App\Models\Favoris;
use App\Models\Paiement;
use App\Models\Bien;
use App\Models\ModePaiement;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class ClientWebController extends Controller
{
    // Vérifier si client connecté
    private function checkAuth()
    {
        if (!session('client')) {
            return redirect()->route('login')
                           ->with('error', 'Connectez-vous d\'abord');
        }
        return null;
    }

    // ═══ PROFIL ═══
    public function profil()
    {
        if ($redirect = $this->checkAuth()) return $redirect;
        $client = Client::find(session('client')->id_client);
        return view('client.profil', compact('client'));
    }

    public function updateProfil(Request $request)
    {
        if ($redirect = $this->checkAuth()) return $redirect;

        $client = Client::find(session('client')->id_client);

        $request->validate([
            'nom_client'    => 'required|string',
            'prenom_client' => 'required|string',
            'tel_client'    => 'required|string',
            'email'         => 'required|email|unique:clients,email,' .
                               $client->id_client . ',id_client',
        ]);

        $client->update($request->only([
            'nom_client', 'prenom_client',
            'email', 'tel_client'
        ]));

        session(['client' => $client->fresh()]);

        return back()->with('success', 'Profil mis à jour avec succès !');
    }

    public function updateMotDePasse(Request $request)
    {
        if ($redirect = $this->checkAuth()) return $redirect;

        $request->validate([
            'ancien_mot_de_passe'  => 'required',
            'nouveau_mot_de_passe' => 'required|min:6|confirmed',
        ]);

        $client = Client::find(session('client')->id_client);

        if (!Hash::check($request->ancien_mot_de_passe, $client->mot_de_passe)) {
            return back()->with('error', 'Ancien mot de passe incorrect');
        }

        $client->update([
            'mot_de_passe' => Hash::make($request->nouveau_mot_de_passe)
        ]);

        return back()->with('success', 'Mot de passe modifié avec succès !');
    }

    // ═══ RESERVATIONS ═══
    public function reservations()
    {
        if ($redirect = $this->checkAuth()) return $redirect;

        $contrats = Contrat::with(['bien.agence', 'bien.ville', 'location', 'vente', 'paiements'])
                           ->where('id_client', session('client')->id_client)
                           ->latest()
                           ->get();

        return view('client.reservations', compact('contrats'));
    }

    public function reserver(Request $request)
    {
        if ($redirect = $this->checkAuth()) return $redirect;

        $request->validate([
            'id_bien'      => 'required|exists:biens,id_bien',
            'type_contrat' => 'required|in:location,vente',
        ]);

        $bien = Bien::find($request->id_bien);

        if ($bien->statut !== 'disponible') {
            return back()->with('error', 'Ce bien n\'est plus disponible');
        }

        $contrat = Contrat::create([
            'id_client'      => session('client')->id_client,
            'id_bien'        => $request->id_bien,
            'type_contrat'   => $request->type_contrat,
            'statut_contrat' => 'en_attente',
            'date_location'  => now(),
        ]);

        if ($request->type_contrat === 'location') {
            \App\Models\Location::create([
                'id_contrat'                => $contrat->id_contrat,
                'montant_total_location'    => $bien->prix,
                'date_reserv_location'      => now(),
                'date_limite_solde_location'=> now()->addDays(7),
            ]);
        } else {
            \App\Models\Vente::create([
                'id_contrat'              => $contrat->id_contrat,
                'montant_total_vente'     => $bien->prix,
                'date_reserv_vente'       => now(),
                'date_limite_solde_vente' => now()->addDays(30),
            ]);
        }

        $bien->update(['statut' => 'reserve']);

        return redirect()->route('client.reservations')
                        ->with('success', 'Réservation effectuée avec succès !');
    }

    // ═══ PAIEMENT ═══
    public function payer(Request $request)
    {
        if ($redirect = $this->checkAuth()) return $redirect;

        $request->validate([
            'id_contrat'       => 'required|exists:contrats,id_contrat',
            'id_mode_paiement' => 'required|exists:mode_paiements,id_mode_paiement',
            'montant'          => 'required|numeric|min:1',
            'type_paiement'    => 'required|in:acompte,solde,complet',
        ]);

        $contrat = Contrat::with(['paiements', 'location', 'vente', 'bien'])
                          ->find($request->id_contrat);

        $montantTotal = $contrat->type_contrat === 'location'
            ? $contrat->location->montant_total_location
            : $contrat->vente->montant_total_vente;

        $acompte = $montantTotal * 0.10;

        if ($request->type_paiement === 'acompte' && $request->montant < $acompte) {
            return back()->with('error',
                'L\'acompte minimum est de ' .
                number_format($acompte, 0, ',', ' ') . ' FCFA'
            );
        }

        $paiement = Paiement::create([
            'id_contrat'       => $request->id_contrat,
            'id_mode_paiement' => $request->id_mode_paiement,
            'montant'          => $request->montant,
            'date_paiement'    => now(),
            'type_paiement'    => $request->type_paiement,
            'reference'        => 'PAY-' . strtoupper(Str::random(10)),
        ]);

        $totalPaye = $contrat->paiements->sum('montant') + $request->montant;

        if ($totalPaye >= $montantTotal) {
            $contrat->update(['statut_contrat' => 'confirme']);
            $statut = $contrat->type_contrat === 'location' ? 'loue' : 'vendu';
            $contrat->bien->update(['statut' => $statut]);
        }

        return redirect()->route('client.reservations')
                        ->with('success', 'Paiement effectué ! Référence : ' .
                                          $paiement->reference);
    }

    // ═══ FAVORIS ═══
    public function favoris()
    {
        if ($redirect = $this->checkAuth()) return $redirect;

        $favoris = Favoris::with(['bien.ville', 'bien.typeBien'])
                        ->where('id_client', session('client')->id_client)
                        ->whereHas('bien')
                        ->get();

        return view('client.favoris', compact('favoris'));
    }

    public function ajouterFavori(Request $request)
    {
        if ($redirect = $this->checkAuth()) return $redirect;

        $existe = Favoris::where('id_client', session('client')->id_client)
                         ->where('id_bien', $request->id_bien)
                         ->first();

        if ($existe) {
            return back()->with('error', 'Bien déjà dans vos favoris');
        }

        Favoris::create([
            'id_client' => session('client')->id_client,
            'id_bien'   => $request->id_bien,
        ]);

        return back()->with('success', 'Ajouté aux favoris !');
    }

    public function supprimerFavori($id)
    {
        if ($redirect = $this->checkAuth()) return $redirect;

        Favoris::where('id_favoris', $id)
               ->where('id_client', session('client')->id_client)
               ->delete();

        return back()->with('success', 'Retiré des favoris');
    }


    public function payerTotal(Request $request)
{
    if ($redirect = $this->checkAuth()) return $redirect;

    $request->validate([
        'id_bien'          => 'required|exists:biens,id_bien',
        'type_contrat'     => 'required|in:location,vente',
        'id_mode_paiement' => 'required|exists:mode_paiements,id_mode_paiement',
    ]);

    $bien = Bien::find($request->id_bien);

    if ($bien->statut !== 'disponible') {
        return back()->with('error', 'Ce bien n\'est plus disponible');
    }

    // Créer le contrat
    $contrat = Contrat::create([
        'id_client'      => session('client')->id_client,
        'id_bien'        => $request->id_bien,
        'type_contrat'   => $request->type_contrat,
        'statut_contrat' => 'confirme',
        'date_location'  => now(),
    ]);

    // Créer location ou vente
    if ($request->type_contrat === 'location') {
        \App\Models\Location::create([
            'id_contrat'                => $contrat->id_contrat,
            'montant_total_location'    => $bien->prix,
            'date_reserv_location'      => now(),
            'date_limite_solde_location'=> now(),
        ]);
    } else {
        \App\Models\Vente::create([
            'id_contrat'              => $contrat->id_contrat,
            'montant_total_vente'     => $bien->prix,
            'date_reserv_vente'       => now(),
            'date_limite_solde_vente' => now(),
        ]);
    }

    // Créer le paiement total
    $paiement = Paiement::create([
        'id_contrat'       => $contrat->id_contrat,
        'id_mode_paiement' => $request->id_mode_paiement,
        'montant'          => $bien->prix,
        'date_paiement'    => now(),
        'type_paiement'    => 'complet',
        'reference'        => 'PAY-' . strtoupper(Str::random(10)),
    ]);

    // Mettre à jour le statut du bien
    $statut = $request->type_contrat === 'location' ? 'loue' : 'vendu';
    $bien->update(['statut' => $statut]);

    return redirect()->route('client.reservations')
                    ->with('success',
                           'Paiement effectué ! Référence : ' . $paiement->reference);
    }
}