<?php
namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\SuperAdmin;
use App\Models\Agence;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class SuperAdminController extends Controller
{
    // Créer une agence
    public function creerAgence(Request $request)
    {
        $request->validate([
            'id_superadmin'  => 'required|exists:super_admins,id_superadmin',
            'nom_agence'     => 'required|string',
            'adresse_agence' => 'required|string',
            'tel_agence'     => 'required|string',
            'email'          => 'required|email|unique:agences,email',
            'logo'           => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        $logoPath = null;
        if ($request->hasFile('logo')) {
            $logoPath = $request->file('logo')->store('logos', 'public');
        }

        $agence = Agence::create([
            'id_superadmin'  => $request->id_superadmin,
            'nom_agence'     => $request->nom_agence,
            'adresse_agence' => $request->adresse_agence,
            'tel_agence'     => $request->tel_agence,
            'email'          => $request->email,
            'logo'           => $logoPath,
        ]);

        return response()->json([
            'message' => 'Agence créée avec succès',
            'agence'  => $agence
        ], 201);
    }

    // Liste des agences
    public function listeAgences()
    {
        $agences = Agence::with('administrateurs')->get();
        return response()->json($agences);
    }

    // Modifier une agence
    public function modifierAgence(Request $request, $id)
    {
        $agence = Agence::where('id_agence', $id)->firstOrFail();
        $agence->update($request->all());
        return response()->json([
            'message' => 'Agence modifiée avec succès',
            'agence'  => $agence
        ]);
    }

    // Supprimer une agence
    public function supprimerAgence($id)
    {
        $agence = Agence::where('id_agence', $id)->firstOrFail();
        $agence->delete();
        return response()->json(['message' => 'Agence supprimée avec succès']);
    }
}