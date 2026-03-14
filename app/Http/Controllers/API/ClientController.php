<?php
namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Client;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class ClientController extends Controller
{
    // Profil du client
    public function show($id)
    {
        $client = Client::where('id_client', $id)->firstOrFail();
        return response()->json($client);
    }

    // Modifier profil
    public function update(Request $request, $id)
    {
        $client = Client::where('id_client', $id)->firstOrFail();

        $request->validate([
            'nom_client'    => 'sometimes|string',
            'prenom_client' => 'sometimes|string',
            'email'         => 'sometimes|email|unique:clients,email,' . $id . ',id_client',
            'tel_client'    => 'sometimes|string',
        ]);

        $client->update($request->only([
            'nom_client',
            'prenom_client',
            'email',
            'tel_client'
        ]));

        return response()->json([
            'message' => 'Profil modifié avec succès',
            'client'  => $client
        ]);
    }

    // Modifier mot de passe
    public function modifierMotDePasse(Request $request, $id)
    {
        $request->validate([
            'ancien_mot_de_passe'  => 'required',
            'nouveau_mot_de_passe' => 'required|min:6|confirmed',
        ]);

        $client = Client::where('id_client', $id)->firstOrFail();

        if (!Hash::check($request->ancien_mot_de_passe, $client->mot_de_passe)) {
            return response()->json([
                'message' => 'Ancien mot de passe incorrect'
            ], 400);
        }

        $client->update([
            'mot_de_passe' => Hash::make($request->nouveau_mot_de_passe)
        ]);

        return response()->json([
            'message' => 'Mot de passe modifié avec succès'
        ]);
    }

    // Supprimer compte
    public function destroy($id)
    {
        $client = Client::where('id_client', $id)->firstOrFail();
        $client->delete();
        return response()->json([
            'message' => 'Compte supprimé avec succès'
        ]);
    }

    // Liste tous les clients (super admin)
    public function index()
    {
        $clients = Client::all();
        return response()->json($clients);
    }
}