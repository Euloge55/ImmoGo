@extends('layouts.app')
@section('title', 'Super Admin')

@section('content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-5">

            <div class="card shadow border-0 rounded-4">
                <div class="card-body p-5">

                    <div class="text-center mb-4">
                        <i class="fas fa-crown fa-3x mb-3" style="color: #4ECDC4"></i>
                        <h2 class="fw-bold">Super Administrateur</h2>
                        <p class="text-muted">Accès plateforme globale</p>
                    </div>

                    @if($errors->any())
                        <div class="alert alert-danger">
                            <i class="fas fa-exclamation-circle me-2"></i>
                            {{ $errors->first() }}
                        </div>
                    @endif

                    <form action="{{ route('login.superadmin') }}" method="POST">
                        @csrf

                        <div class="mb-3">
                            <label class="form-label fw-semibold">Email</label>
                            <input
                                type="email"
                                name="email"
                                class="form-control @error('email') is-invalid @enderror"
                                value="{{ old('email') }}"
                                placeholder="superadmin@immogo.com"
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

                </div>
            </div>

        </div>
    </div>
</div>
@endsection