<?php
namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\Client;
use App\Models\Administrateur;
use App\Models\SuperAdmin;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;

class AuthWebController extends Controller
{
    // ═══ INSCRIPTION ═══
    public function showRegister()
    {
        return view('auth.register');
    }

    public function register(Request $request)
    {
        $request->validate([
            'nom_client'    => 'required|string',
            'prenom_client' => 'required|string',
            'email'         => 'required|email|unique:clients,email',
            'tel_client'    => 'required|string',
            'mot_de_passe'  => 'required|min:6|confirmed',
        ]);

        $client = Client::create([
            'nom_client'    => $request->nom_client,
            'prenom_client' => $request->prenom_client,
            'email'         => $request->email,
            'tel_client'    => $request->tel_client,
            'mot_de_passe'  => Hash::make($request->mot_de_passe),
        ]);

        // Connecter le client après inscription
        Session::put('client', $client);
        Session::put('type', 'client');

        return redirect()->route('home')
                         ->with('success', 'Compte créé avec succès !');
    }

    // ═══ CONNEXION CLIENT ═══
    public function showLogin()
    {
        return view('auth.login');
    }

    public function login(Request $request)
    {
        $request->validate([
            'email'        => 'required|email',
            'mot_de_passe' => 'required',
        ]);

        $client = Client::where('email', $request->email)->first();

        if (!$client || !Hash::check($request->mot_de_passe, $client->mot_de_passe)) {
            return back()->withErrors([
                'email' => 'Email ou mot de passe incorrect'
            ])->withInput();
        }

        Session::put('client', $client);
        Session::put('type', 'client');

        return redirect()->route('home')
                         ->with('success', 'Connexion réussie !');
    }

    // ═══ CONNEXION ADMIN ═══
    public function showLoginAdmin()
    {
        return view('auth.login-admin');
    }

    public function loginAdmin(Request $request)
    {
        $request->validate([
            'email'        => 'required|email',
            'mot_de_passe' => 'required',
        ]);

        $admin = Administrateur::where('email', $request->email)->first();

        if (!$admin || !Hash::check($request->mot_de_passe, $admin->mot_de_passe)) {
            return back()->withErrors([
                'email' => 'Email ou mot de passe incorrect'
            ])->withInput();
        }

        Session::put('admin', $admin);
        Session::put('type', 'admin');

        return redirect()->route('admin.dashboard')
                         ->with('success', 'Connexion réussie !');
    }

    // ═══ CONNEXION SUPER ADMIN ═══
    public function showLoginSuperAdmin()
    {
        return view('auth.login-superadmin');
    }

    public function loginSuperAdmin(Request $request)
    {
        $request->validate([
            'email'        => 'required|email',
            'mot_de_passe' => 'required',
        ]);

        $superAdmin = SuperAdmin::where('email', $request->email)->first();

        if (!$superAdmin || !Hash::check($request->mot_de_passe, $superAdmin->mot_de_passe)) {
            return back()->withErrors([
                'email' => 'Email ou mot de passe incorrect'
            ])->withInput();
        }

        Session::put('superadmin', $superAdmin);
        Session::put('type', 'superadmin');

        return redirect()->route('superadmin.dashboard')
                         ->with('success', 'Connexion réussie !');
    }

    // ═══ DECONNEXION ═══
    public function logout()
    {
        Session::flush();
        return redirect()->route('login')
                         ->with('success', 'Déconnexion réussie !');
    }
}