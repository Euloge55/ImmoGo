<?php
namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Administrateur;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AgenceController extends Controller
{
    // Créer un administrateur
    public function creerAdministrateur(Request $request)
    {
        $request->validate([
            'id_agence'     => 'required|exists:agences,id_agence',
            'nom_admin'     => 'required|string',
            'prenom_admin'  => 'required|string',
            'email'         => 'required|email|unique:administrateurs,email',
            'mot_de_passe'  => 'required|min:6',
            'est_principal' => 'boolean',
        ]);

        $admin = Administrateur::create([
            'id_agence'     => $request->id_agence,
            'nom_admin'     => $request->nom_admin,
            'prenom_admin'  => $request->prenom_admin,
            'email'         => $request->email,
            'mot_de_passe'  => Hash::make($request->mot_de_passe),
            'est_principal' => $request->est_principal ?? false,
        ]);

        return response()->json([
            'message' => 'Administrateur créé avec succès',
            'admin'   => $admin
        ], 201);
    }

    // Liste des administrateurs d'une agence
    public function listeAdministrateurs($id_agence)
    {
        $admins = Administrateur::where('id_agence', $id_agence)->get();
        return response()->json($admins);
    }

    // Modifier un administrateur
    public function modifierAdministrateur(Request $request, $id)
    {
        $admin = Administrateur::where('id_admin', $id)->firstOrFail();
        if ($request->mot_de_passe) {
            $request->merge(['mot_de_passe' => Hash::make($request->mot_de_passe)]);
        }
        $admin->update($request->all());
        return response()->json([
            'message' => 'Administrateur modifié avec succès',
            'admin'   => $admin
        ]);
    }

    // Supprimer un administrateur
    public function supprimerAdministrateur($id)
    {
        $admin = Administrateur::where('id_admin', $id)->firstOrFail();
        $admin->delete();
        return response()->json(['message' => 'Administrateur supprimé avec succès']);
    }
}