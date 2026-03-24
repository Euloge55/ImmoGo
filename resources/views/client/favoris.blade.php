@extends('layouts.app')
@section('title', 'Mes Favoris')

@section('content')
<div class="container py-5">

    <h3 class="fw-bold mb-4">
        <i class="fas fa-heart me-2" style="color:#e74c3c"></i>Mes Favoris
    </h3>

    @if($favoris->isEmpty())
        <div class="text-center py-5">
            <i class="fas fa-heart fa-4x text-muted mb-3"></i>
            <h4 class="text-muted">Aucun favori</h4>
            <a href="{{ route('biens.index') }}"
               class="btn fw-semibold mt-3"
               style="background:#4ECDC4; color:white; border-radius:10px">
                Découvrir les biens
            </a>
        </div>
    @else
        <div class="row g-4">
            @foreach($favoris as $favori)
            @if($favori->bien)
            <div class="col-md-4">
                <div class="card border-0 rounded-4 shadow-sm h-100">
                    <div style="height:200px; border-radius:16px 16px 0 0;
                                overflow:hidden;
                                background:linear-gradient(135deg,#4ECDC4,#2C3E50);
                                display:flex; align-items:center;
                                justify-content:center">
                        @if($favori->bien->photos && count($favori->bien->photos) > 0)
                            <img src="{{ asset('storage/' . $favori->bien->photos[0]) }}"
                                 style="width:100%; height:100%; object-fit:cover"
                                 alt="{{ $favori->bien->titre_bien }}">
                        @else
                            <i class="fas fa-building fa-3x text-white opacity-50"></i>
                        @endif
                    </div>
                    <div class="card-body p-3">
                        <span class="badge mb-2
                            @if($favori->bien->statut == 'disponible') bg-success
                            @elseif($favori->bien->statut == 'reserve') bg-warning text-dark
                            @elseif($favori->bien->statut == 'loue') bg-info
                            @else bg-danger @endif">
                            {{ ucfirst($favori->bien->statut) }}
                        </span>
                        <h6 class="fw-bold mb-1">
                            {{ $favori->bien->titre_bien }}
                        </h6>
                        <p class="text-muted small mb-1">
                            <i class="fas fa-tag me-1" style="color:#4ECDC4"></i>
                            {{ $favori->bien->typeBien->libelle ?? 'N/A' }}
                        </p>
                        <p class="text-muted small mb-2">
                            <i class="fas fa-map-marker-alt me-1"
                               style="color:#4ECDC4"></i>
                            {{ $favori->bien->ville->nom_ville ?? 'N/A' }}
                        </p>
                        <p class="fw-bold mb-3" style="color:#4ECDC4">
                            {{ number_format($favori->bien->prix, 0, ',', ' ') }}
                            <small class="text-muted fw-normal">FCFA</small>
                        </p>
                        <div class="d-flex gap-2">
                            <a href="{{ route('biens.show', $favori->bien->id_bien) }}"
                               class="btn btn-sm flex-fill fw-semibold"
                               style="background:#4ECDC4; color:white;
                                      border-radius:8px">
                                <i class="fas fa-eye me-1"></i>Voir
                            </a>
                            <form action="{{ route('client.favoris.supprimer',
                                          $favori->id_favoris) }}"
                                  method="POST">
                                @csrf @method('DELETE')
                                <button type="submit"
                                        class="btn btn-sm btn-outline-danger"
                                        style="border-radius:8px">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
            @else
                @php
                    \App\Models\Favoris::where('id_favoris', $favori->id_favoris)
                                      ->delete();
                @endphp
            @endif
            @endforeach
        </div>
    @endif
</div>
@endsection