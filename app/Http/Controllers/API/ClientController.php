<?php
namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Client;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class ClientController extends Controller
{
    // ── Profil du client connecté (GET /me) ──
    public function me(Request $request)
    {
        return response()->json($request->user());
    }

    // ── Modifier son propre profil (PUT /me) ──
    public function updateMe(Request $request)
    {
        $client = $request->user();

        $request->validate([
            'nom_client'    => 'sometimes|string|max:100',
            'prenom_client' => 'sometimes|string|max:100',
            'email'         => 'sometimes|email|unique:clients,email,' . $client->id_client . ',id_client',
            'tel_client'    => 'sometimes|string|max:20',
        ]);

        $client->update($request->only(['nom_client', 'prenom_client', 'email', 'tel_client']));

        return response()->json([
            'message' => 'Profil modifié avec succès',
            'client'  => $client
        ]);
    }

    // ── Modifier son propre mot de passe (PATCH /me/mot-de-passe) ──
    public function modifierMotDePasseMe(Request $request)
    {
        $request->validate([
            'ancien_mot_de_passe'                  => 'required',
            'nouveau_mot_de_passe'                 => 'required|min:6|confirmed',
            'nouveau_mot_de_passe_confirmation'    => 'required',
        ]);

        $client = $request->user();

        if (!Hash::check($request->ancien_mot_de_passe, $client->mot_de_passe)) {
            return response()->json(['message' => 'Ancien mot de passe incorrect'], 400);
        }

        $client->update(['mot_de_passe' => Hash::make($request->nouveau_mot_de_passe)]);

        return response()->json(['message' => 'Mot de passe modifié avec succès']);
    }

    // ── Admin : profil d'un client par id ──
    public function show($id)
    {
        $client = Client::where('id_client', $id)->firstOrFail();
        return response()->json($client);
    }

    // ── Admin : modifier un client ──
    public function update(Request $request, $id)
    {
        $client = Client::where('id_client', $id)->firstOrFail();

        $request->validate([
            'nom_client'    => 'sometimes|string',
            'prenom_client' => 'sometimes|string',
            'email'         => 'sometimes|email|unique:clients,email,' . $id . ',id_client',
            'tel_client'    => 'sometimes|string',
        ]);

        $client->update($request->only(['nom_client', 'prenom_client', 'email', 'tel_client']));

        return response()->json([
            'message' => 'Profil modifié avec succès',
            'client'  => $client
        ]);
    }

    // ── Admin : modifier mot de passe d'un client ──
    public function modifierMotDePasse(Request $request, $id)
    {
        $request->validate([
            'ancien_mot_de_passe'  => 'required',
            'nouveau_mot_de_passe' => 'required|min:6|confirmed',
        ]);

        $client = Client::where('id_client', $id)->firstOrFail();

        if (!Hash::check($request->ancien_mot_de_passe, $client->mot_de_passe)) {
            return response()->json(['message' => 'Ancien mot de passe incorrect'], 400);
        }

        $client->update(['mot_de_passe' => Hash::make($request->nouveau_mot_de_passe)]);

        return response()->json(['message' => 'Mot de passe modifié avec succès']);
    }

    // ── Admin : supprimer un client ──
    public function destroy($id)
    {
        $client = Client::where('id_client', $id)->firstOrFail();
        $client->delete();
        return response()->json(['message' => 'Compte supprimé avec succès']);
    }

    // ── SuperAdmin : liste tous les clients ──
    public function index()
    {
        return response()->json(Client::paginate(20));
    }
}
