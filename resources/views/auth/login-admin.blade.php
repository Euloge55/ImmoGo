@extends('layouts.app')
@section('title', 'Connexion Admin')

@section('content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-5">

            <div class="card shadow border-0 rounded-4">
                <div class="card-body p-5">

                    <div class="text-center mb-4">
                        <i class="fas fa-user-shield fa-3x mb-3" style="color: #4ECDC4"></i>
                        <h2 class="fw-bold">Espace Admin</h2>
                        <p class="text-muted">Connexion Administrateur d'Agence</p>
                    </div>

                    @if($errors->any())
                        <div class="alert alert-danger">
                            <i class="fas fa-exclamation-circle me-2"></i>
                            {{ $errors->first() }}
                        </div>
                    @endif

                    <form action="{{ route('login.admin') }}" method="POST">
                        @csrf

                        <div class="mb-3">
                            <label class="form-label fw-semibold">Email</label>
                            <input
                                type="email"
                                name="email"
                                class="form-control @error('email') is-invalid @enderror"
                                value="{{ old('email') }}"
                                placeholder="admin@agence.com"
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
                        <a href="{{ route('login') }}" class="text-decoration-none text-muted small">
                            <i class="fas fa-user me-1"></i>Connexion Client
                        </a>
                        <span class="mx-2 text-muted">|</span>
                        <a href="{{ route('login.superadmin') }}" class="text-decoration-none text-muted small">
                            <i class="fas fa-crown me-1"></i>Super Admin
                        </a>
                    </div>

                </div>
            </div>

        </div>
    </div>
</div>
@endsection