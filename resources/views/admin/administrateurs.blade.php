@extends('layouts.admin')
@section('title', 'Administrateurs')

@section('content')

<div class="d-flex justify-content-between align-items-center mb-4">
    <h4 class="fw-bold mb-0">Administrateurs de l'agence</h4>

    {{-- Seul l'admin principal peut ajouter --}}
    @if(session('admin')->est_principal)
        <button class="btn fw-semibold"
                style="background:#4ECDC4; color:white; border-radius:10px"
                data-bs-toggle="modal" data-bs-target="#modalCreerAdmin">
            <i class="fas fa-plus me-2"></i>Ajouter
        </button>
    @endif
</div>

<div class="row g-4">
    @forelse($admins as $admin)
    <div class="col-md-4">
        <div class="card border-0 rounded-4 shadow-sm p-4">
            <div class="text-center mb-3">
                <div class="rounded-circle d-inline-flex align-items-center
                            justify-content-center mb-3"
                     style="width:60px; height:60px; background:#e8fffe">
                    <i class="fas fa-user fa-2x" style="color:#4ECDC4"></i>
                </div>
                <h6 class="fw-bold mb-0">
                    {{ $admin->prenom_admin }} {{ $admin->nom_admin }}
                </h6>
                <small class="text-muted">{{ $admin->email }}</small>
                <br>
                @if($admin->est_principal)
                    <span class="badge mt-1" style="background:#4ECDC4">
                        Principal
                    </span>
                @else
                    <span class="badge bg-secondary mt-1">Assistant</span>
                @endif
            </div>

            {{-- Seul l'admin principal peut supprimer les autres --}}
            @if(session('admin')->est_principal && !$admin->est_principal)
                <form action="{{ route('admin.administrateurs.supprimer',
                              $admin->id_admin) }}"
                      method="POST"
                      onsubmit="return confirm('Supprimer cet administrateur ?')">
                    @csrf @method('DELETE')
                    <button type="submit"
                            class="btn btn-outline-danger btn-sm w-100">
                        <i class="fas fa-trash me-2"></i>Supprimer
                    </button>
                </form>
            @elseif(!$admin->est_principal &&
                    $admin->id_admin == session('admin')->id_admin)
                {{-- L'admin non principal voit son propre compte en grisé --}}
                <button class="btn btn-secondary btn-sm w-100" disabled>
                    <i class="fas fa-lock me-2"></i>Compte protégé
                </button>
            @endif
        </div>
    </div>
    @empty
    <div class="col-12 text-center py-5">
        <p class="text-muted">Aucun administrateur</p>
    </div>
    @endforelse
</div>

{{-- Modal créer admin — visible seulement pour admin principal --}}
@if(session('admin')->est_principal)
<div class="modal fade" id="modalCreerAdmin" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content border-0 rounded-4">
            <div class="modal-header border-0"
                 style="background:linear-gradient(135deg,#4ECDC4,#2C3E50);
                        border-radius:16px 16px 0 0">
                <h5 class="modal-title fw-bold text-white">
                    <i class="fas fa-user-plus me-2"></i>
                    Créer un administrateur assistant
                </h5>
                <button type="button" class="btn-close btn-close-white"
                        data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body p-4">
                <div class="alert border-0 rounded-3 mb-3"
                     style="background:#e8fffe">
                    <i class="fas fa-info-circle me-2"
                       style="color:#4ECDC4"></i>
                    Cet administrateur pourra consulter les biens
                    et réservations mais ne pourra pas gérer les autres admins.
                </div>
                <form action="{{ route('admin.administrateurs.creer') }}"
                      method="POST">
                    @csrf
                    <div class="mb-3">
                        <label class="form-label fw-semibold">Nom</label>
                        <input type="text" name="nom_admin"
                               class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-semibold">Prénom</label>
                        <input type="text" name="prenom_admin"
                               class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-semibold">Email</label>
                        <input type="email" name="email"
                               class="form-control" required>
                    </div>
                    <div class="mb-4">
                        <label class="form-label fw-semibold">Mot de passe</label>
                        <input type="password" name="mot_de_passe"
                               class="form-control" required>
                    </div>
                    <button type="submit" class="btn w-100 fw-semibold"
                            style="background:#4ECDC4; color:white">
                        <i class="fas fa-user-plus me-2"></i>Créer
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>
@endif

@endsection