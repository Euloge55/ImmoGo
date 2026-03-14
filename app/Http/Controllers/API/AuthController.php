<?php
namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Client;
use App\Models\Administrateur;
use App\Models\SuperAdmin;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    // Inscription Client
    public function registerClient(Request $request)
    {
        $request->validate([
            'nom_client'    => 'required|string',
            'prenom_client' => 'required|string',
            'email'         => 'required|email|unique:clients,email',
            'tel_client'    => 'required|string',
            'mot_de_passe'  => 'required|min:6',
        ]);

        $client = Client::create([
            'nom_client'    => $request->nom_client,
            'prenom_client' => $request->prenom_client,
            'email'         => $request->email,
            'tel_client'    => $request->tel_client,
            'mot_de_passe'  => Hash::make($request->mot_de_passe),
        ]);

        return response()->json([
            'message' => 'Compte client créé avec succès',
            'client'  => $client
        ], 201);
    }

    // Connexion Client
    public function loginClient(Request $request)
    {
        $request->validate([
            'email'        => 'required|email',
            'mot_de_passe' => 'required',
        ]);

        $client = Client::where('email', $request->email)->first();

        if (!$client || !Hash::check($request->mot_de_passe, $client->mot_de_passe)) {
            return response()->json(['message' => 'Email ou mot de passe incorrect'], 401);
        }

        $token = $client->createToken('client_token')->plainTextToken;

        return response()->json([
            'message' => 'Connexion réussie',
            'token'   => $token,
            'client'  => $client
        ]);
    }

    // Connexion Administrateur
    public function loginAdmin(Request $request)
    {
        $request->validate([
            'email'        => 'required|email',
            'mot_de_passe' => 'required',
        ]);

        $admin = Administrateur::where('email', $request->email)->first();

        if (!$admin || !Hash::check($request->mot_de_passe, $admin->mot_de_passe)) {
            return response()->json(['message' => 'Email ou mot de passe incorrect'], 401);
        }

        $token = $admin->createToken('admin_token')->plainTextToken;

        return response()->json([
            'message' => 'Connexion réussie',
            'token'   => $token,
            'admin'   => $admin
        ]);
    }

    // Connexion SuperAdmin
    public function loginSuperAdmin(Request $request)
    {
        $request->validate([
            'email'        => 'required|email',
            'mot_de_passe' => 'required',
        ]);

        $superAdmin = SuperAdmin::where('email', $request->email)->first();

        if (!$superAdmin || !Hash::check($request->mot_de_passe, $superAdmin->mot_de_passe)) {
            return response()->json(['message' => 'Email ou mot de passe incorrect'], 401);
        }

        $token = $superAdmin->createToken('superadmin_token')->plainTextToken;

        return response()->json([
            'message'    => 'Connexion réussie',
            'token'      => $token,
            'superAdmin' => $superAdmin
        ]);
    }

    // Déconnexion
    public function logout(Request $request)
    {
        $request->user()->currentAccessToken()->delete();
        return response()->json(['message' => 'Déconnexion réussie']);
    }
}