@extends('layouts.app')
@section('title', 'Mon Profil')

@section('content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-8">

            <h3 class="fw-bold mb-4">
                <i class="fas fa-user me-2" style="color:#4ECDC4"></i>Mon Profil
            </h3>

            <!-- MODIFIER PROFIL -->
            <div class="card border-0 rounded-4 shadow-sm mb-4">
                <div class="card-body p-4">
                    <h5 class="fw-bold mb-4">Informations personnelles</h5>
                    <form action="{{ route('client.profil.update') }}" method="POST">
                        @csrf @method('PUT')
                        <div class="row g-3">
                            <div class="col-md-6">
                                <label class="form-label fw-semibold">Nom</label>
                                <input type="text" name="nom_client"
                                       class="form-control"
                                       value="{{ $client->nom_client }}" required>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label fw-semibold">Prénom</label>
                                <input type="text" name="prenom_client"
                                       class="form-control"
                                       value="{{ $client->prenom_client }}" required>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label fw-semibold">Email</label>
                                <input type="email" name="email"
                                       class="form-control"
                                       value="{{ $client->email }}" required>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label fw-semibold">Téléphone</label>
                                <input type="text" name="tel_client"
                                       class="form-control"
                                       value="{{ $client->tel_client }}" required>
                            </div>
                        </div>
                        <button type="submit" class="btn mt-3 fw-semibold"
                                style="background:#4ECDC4; color:white; border-radius:10px">
                            <i class="fas fa-save me-2"></i>Enregistrer
                        </button>
                    </form>
                </div>
            </div>

            <!-- MODIFIER MOT DE PASSE -->
            <div class="card border-0 rounded-4 shadow-sm">
                <div class="card-body p-4">
                    <h5 class="fw-bold mb-4">Changer le mot de passe</h5>
                    <form action="{{ route('client.password.update') }}" method="POST">
                        @csrf @method('PATCH')
                        <div class="mb-3">
                            <label class="form-label fw-semibold">
                                Ancien mot de passe
                            </label>
                            <input type="password" name="ancien_mot_de_passe"
                                   class="form-control" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label fw-semibold">
                                Nouveau mot de passe
                            </label>
                            <input type="password" name="nouveau_mot_de_passe"
                                   class="form-control" required>
                        </div>
                        <div class="mb-4">
                            <label class="form-label fw-semibold">Confirmer</label>
                            <input type="password"
                                   name="nouveau_mot_de_passe_confirmation"
                                   class="form-control" required>
                        </div>
                        <button type="submit" class="btn btn-outline-danger fw-semibold"
                                style="border-radius:10px">
                            <i class="fas fa-lock me-2"></i>Modifier le mot de passe
                        </button>
                    </form>
                </div>
            </div>

        </div>
    </div>
</div>
@endsection