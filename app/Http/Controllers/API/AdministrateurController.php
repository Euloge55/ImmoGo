<?php
namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Administrateur;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AdministrateurController extends Controller
{
    // Profil administrateur
    public function show($id)
    {
        $admin = Administrateur::with('agence')
                               ->where('id_admin', $id)
                               ->firstOrFail();
        return response()->json($admin);
    }

    // Modifier profil
    public function update(Request $request, $id)
    {
        $admin = Administrateur::where('id_admin', $id)->firstOrFail();

        $request->validate([
            'nom_admin'    => 'sometimes|string',
            'prenom_admin' => 'sometimes|string',
            'email'        => 'sometimes|email|unique:administrateurs,email,' . $id . ',id_admin',
        ]);

        $admin->update($request->only([
            'nom_admin',
            'prenom_admin',
            'email',
        ]));

        return response()->json([
            'message' => 'Profil modifié avec succès',
            'admin'   => $admin
        ]);
    }

    // Modifier mot de passe
    public function modifierMotDePasse(Request $request, $id)
    {
        $request->validate([
            'ancien_mot_de_passe'  => 'required',
            'nouveau_mot_de_passe' => 'required|min:6|confirmed',
        ]);

        $admin = Administrateur::where('id_admin', $id)->firstOrFail();

        if (!Hash::check($request->ancien_mot_de_passe, $admin->mot_de_passe)) {
            return response()->json([
                'message' => 'Ancien mot de passe incorrect'
            ], 400);
        }

        $admin->update([
            'mot_de_passe' => Hash::make($request->nouveau_mot_de_passe)
        ]);

        return response()->json([
            'message' => 'Mot de passe modifié avec succès'
        ]);
    }

    // Liste des biens gérés par l'administrateur
    public function biens($id)
    {
        $admin = Administrateur::with('biens.typeBien')
                               ->where('id_admin', $id)
                               ->firstOrFail();
        return response()->json($admin->biens);
    }
}