@extends('layouts.app')
@section('title', 'Connexion')

@section('content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-5">

            <div class="card shadow border-0 rounded-4">
                <div class="card-body p-5">

                    <!-- TITRE -->
                    <div class="text-center mb-4">
                        <i class="fas fa-sign-in-alt fa-3x mb-3" style="color: #4ECDC4"></i>
                        <h2 class="fw-bold">Connexion</h2>
                        <p class="text-muted">Bienvenue sur ImmoGo</p>
                    </div>

                    <!-- ERREUR GLOBALE -->
                    @if($errors->any())
                        <div class="alert alert-danger">
                            <i class="fas fa-exclamation-circle me-2"></i>
                            {{ $errors->first() }}
                        </div>
                    @endif

                    <!-- FORMULAIRE -->
                    <form action="{{ route('login') }}" method="POST">
                        @csrf

                        <div class="mb-3">
                            <label class="form-label fw-semibold">Email</label>
                            <input
                                type="email"
                                name="email"
                                class="form-control @error('email') is-invalid @enderror"
                                value="{{ old('email') }}"
                                placeholder="votre@email.com"
                            >
                            @error('email')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-4">
                            <label class="form-label fw-semibold">Mot de passe</label>
                            <input
                                type="password"
                                name="mot_de_passe"
                                class="form-control"
                                placeholder="Votre mot de passe"
                            >
                        </div>

                        <button type="submit" class="btn btn-primary w-100 py-2 fw-semibold">
                            <i class="fas fa-sign-in-alt me-2"></i>Se connecter
                        </button>
                    </form>

                    <hr class="my-4">

                    <div class="text-center">
                        <p class="mb-2">Pas encore de compte ?
                            <a href="{{ route('register') }}" class="text-decoration-none fw-semibold" style="color: #4ECDC4">
                                S'inscrire
                            </a>
                        </p>
                        <p class="mb-0">
                            <a href="{{ route('login.admin') }}" class="text-decoration-none text-muted small">
                                <i class="fas fa-user-shield me-1"></i>Connexion Administrateur
                            </a>
                        </p>
                    </div>

                </div>
            </div>

        </div>
    </div>
</div>
@endsection