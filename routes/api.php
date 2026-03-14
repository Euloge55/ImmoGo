<?php
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\AuthController;
use App\Http\Controllers\API\SuperAdminController;
use App\Http\Controllers\API\AgenceController;
use App\Http\Controllers\API\BienController;
use App\Http\Controllers\API\TypeBienController;
use App\Http\Controllers\API\ContratController;
use App\Http\Controllers\API\PaiementController;
use App\Http\Controllers\API\FavorisController;
use App\Http\Controllers\API\ClientController;
use App\Http\Controllers\API\AdministrateurController;
use App\Http\Controllers\API\LocationController;
use App\Http\Controllers\API\VenteController;
use App\Http\Controllers\API\ModePaiementController;
use App\Http\Controllers\API\LocalisationController;

// ═══ ROUTES PUBLIQUES (sans token) ═══




// ── LOCALISATION ──
Route::get('/departements',                          [LocalisationController::class, 'departements']);
Route::get('/departements/{id}/villes',              [LocalisationController::class, 'villes']);
Route::get('/villes/{id}/quartiers',                 [LocalisationController::class, 'quartiers']);
Route::get('/biens/localisation',                    [LocalisationController::class, 'biensByLocalisation']);
Route::get('/recherche',                             [LocalisationController::class, 'recherche']);

// Auth
Route::post('/register/client',       [AuthController::class, 'registerClient']);
Route::post('/login/client',          [AuthController::class, 'loginClient']);
Route::post('/login/admin',           [AuthController::class, 'loginAdmin']);
Route::post('/login/superadmin',      [AuthController::class, 'loginSuperAdmin']);

// Biens publics (visiteur)
Route::get('/biens',                  [BienController::class, 'index']);
Route::get('/biens/{id}',             [BienController::class, 'show']);
Route::get('/type-biens',             [TypeBienController::class, 'index']);

// ═══ ROUTES PROTÉGÉES (avec token) ═══
Route::middleware('auth:sanctum')->group(function () {

    // Déconnexion
    Route::post('/logout', [AuthController::class, 'logout']);

    // ── SUPER ADMIN ──
    Route::prefix('superadmin')->group(function () {
        Route::post('/agences',              [SuperAdminController::class, 'creerAgence']);
        Route::get('/agences',               [SuperAdminController::class, 'listeAgences']);
        Route::put('/agences/{id}',          [SuperAdminController::class, 'modifierAgence']);
        Route::delete('/agences/{id}',       [SuperAdminController::class, 'supprimerAgence']);
    });

    // ── AGENCE / ADMIN ──
    Route::prefix('agence')->group(function () {
        Route::post('/administrateurs',           [AgenceController::class, 'creerAdministrateur']);
        Route::get('/administrateurs/{id_agence}',[AgenceController::class, 'listeAdministrateurs']);
        Route::put('/administrateurs/{id}',       [AgenceController::class, 'modifierAdministrateur']);
        Route::delete('/administrateurs/{id}',    [AgenceController::class, 'supprimerAdministrateur']);
    });

    // ── BIENS (admin) ──
    Route::post('/biens',                    [BienController::class, 'store']);
    Route::put('/biens/{id}',                [BienController::class, 'update']);
    Route::patch('/biens/{id}/statut',       [BienController::class, 'modifierStatut']);
    Route::delete('/biens/{id}',             [BienController::class, 'destroy']);

    // ── TYPE BIENS ──
    Route::post('/type-biens',               [TypeBienController::class, 'store']);
    Route::delete('/type-biens/{id}',        [TypeBienController::class, 'destroy']);

    // ── CONTRATS ──
    Route::post('/contrats',                          [ContratController::class, 'store']);
    Route::get('/contrats/client/{id_client}',        [ContratController::class, 'contratClient']);
    Route::get('/contrats/agence/{id_agence}',        [ContratController::class, 'contratAgence']);
    Route::get('/contrats/{id}/solde',                [ContratController::class, 'calculerSolde']);

    // ── PAIEMENTS ──
    Route::post('/paiements',                         [PaiementController::class, 'store']);
    Route::get('/paiements/contrat/{id_contrat}',     [PaiementController::class, 'historique']);

    // ── FAVORIS ──
    Route::post('/favoris',                           [FavorisController::class, 'store']);
    Route::get('/favoris/client/{id_client}',         [FavorisController::class, 'index']);
    Route::delete('/favoris/{id}',                    [FavorisController::class, 'destroy']);

    // ── CLIENT ──
    Route::get('/clients',                              [ClientController::class, 'index']);
    Route::get('/clients/{id}',                         [ClientController::class, 'show']);
    Route::put('/clients/{id}',                         [ClientController::class, 'update']);
    Route::delete('/clients/{id}',                      [ClientController::class, 'destroy']);
    Route::patch('/clients/{id}/mot-de-passe',          [ClientController::class, 'modifierMotDePasse']);

    // ── ADMINISTRATEUR ──
    Route::get('/administrateurs/{id}',                 [AdministrateurController::class, 'show']);
    Route::put('/administrateurs/{id}',                 [AdministrateurController::class, 'update']);
    Route::patch('/administrateurs/{id}/mot-de-passe',  [AdministrateurController::class, 'modifierMotDePasse']);
    Route::get('/administrateurs/{id}/biens',           [AdministrateurController::class, 'biens']);

    // ── LOCATIONS ──
    Route::get('/locations/{id}',                       [LocationController::class, 'show']);
    Route::get('/locations/agence/{id_agence}',         [LocationController::class, 'locationAgence']);
    Route::get('/locations/client/{id_client}',         [LocationController::class, 'locationClient']);
    Route::put('/locations/{id}',                       [LocationController::class, 'update']);

    // ── VENTES ──
    Route::get('/ventes/{id}',                          [VenteController::class, 'show']);
    Route::get('/ventes/agence/{id_agence}',            [VenteController::class, 'venteAgence']);
    Route::get('/ventes/client/{id_client}',            [VenteController::class, 'venteClient']);
    Route::put('/ventes/{id}',                          [VenteController::class, 'update']);

    // ── MODE PAIEMENT ──
    Route::get('/mode-paiements',                       [ModePaiementController::class, 'index']);
    Route::post('/mode-paiements',                      [ModePaiementController::class, 'store']);
    Route::put('/mode-paiements/{id}',                  [ModePaiementController::class, 'update']);
    Route::delete('/mode-paiements/{id}',               [ModePaiementController::class, 'destroy']);
});