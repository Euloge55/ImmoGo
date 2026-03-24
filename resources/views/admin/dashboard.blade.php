@extends('layouts.admin')
@section('title', 'Dashboard Admin')

@section('content')

<!-- STATS -->
<div class="row g-4 mb-4">
    <div class="col-md-3">
        <div class="stat-card" style="background:linear-gradient(135deg,#4ECDC4,#3dbdb4)">
            <div class="stat-number">{{ $totalBiens }}</div>
            <p class="mb-0 opacity-75">Total Biens</p>
        </div>
    </div>
    <div class="col-md-3">
        <div class="stat-card" style="background:linear-gradient(135deg,#2ecc71,#27ae60)">
            <div class="stat-number">{{ $biensDisponibles }}</div>
            <p class="mb-0 opacity-75">Disponibles</p>
        </div>
    </div>
    <div class="col-md-3">
        <div class="stat-card" style="background:linear-gradient(135deg,#e67e22,#d35400)">
            <div class="stat-number">{{ $biensReserves }}</div>
            <p class="mb-0 opacity-75">Réservés</p>
        </div>
    </div>
    <div class="col-md-3">
        <div class="stat-card" style="background:linear-gradient(135deg,#3498db,#2980b9)">
            <div class="stat-number">{{ $totalContrats }}</div>
            <p class="mb-0 opacity-75">Contrats</p>
        </div>
    </div>
</div>

<div class="row g-4">
    <!-- DERNIERS CONTRATS -->
    <div class="col-md-7">
        <div class="card border-0 rounded-4 shadow-sm">
            <div class="card-body p-4">
                <h5 class="fw-bold mb-4">
                    <i class="fas fa-calendar-check me-2" style="color:#4ECDC4"></i>
                    Dernières réservations
                </h5>
                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead class="table-light">
                            <tr>
                                <th>Client</th>
                                <th>Bien</th>
                                <th>Type</th>
                                <th>Statut</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($derniersContrats as $contrat)
                            <tr>
                                <td>{{ $contrat->client->nom_client ?? 'N/A' }}</td>
                                <td>{{ $contrat->bien->titre_bien ?? 'N/A' }}</td>
                                <td>
                                    <span class="badge bg-info">
                                        {{ $contrat->type_contrat }}
                                    </span>
                                </td>
                                <td>
                                    @if($contrat->statut_contrat == 'confirme')
                                        <span class="badge bg-success">Confirmé</span>
                                    @elseif($contrat->statut_contrat == 'en_attente')
                                        <span class="badge bg-warning">En attente</span>
                                    @else
                                        <span class="badge bg-danger">Annulé</span>
                                    @endif
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="4" class="text-center text-muted">
                                    Aucune réservation
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
                <a href="{{ route('admin.reservations') }}"
                   class="btn btn-sm"
                   style="background:#4ECDC4; color:white">
                    Voir tout
                </a>
            </div>
        </div>
    </div>

    <!-- DERNIERS BIENS -->
    <div class="col-md-5">
        <div class="card border-0 rounded-4 shadow-sm">
            <div class="card-body p-4">
                <h5 class="fw-bold mb-4">
                    <i class="fas fa-building me-2" style="color:#4ECDC4"></i>
                    Mes derniers biens
                </h5>
                @forelse($derniersBiens as $bien)
                <div class="d-flex justify-content-between align-items-center
                            p-3 mb-2 rounded-3" style="background:#f8f9fa">
                    <div>
                        <p class="mb-0 fw-semibold small">{{ $bien->titre_bien }}</p>
                        <small class="text-muted">
                            {{ $bien->ville->nom_ville ?? 'N/A' }}
                        </small>
                    </div>
                    <span class="badge bg-{{ $bien->statut == 'disponible' ?
                                  'success' : ($bien->statut == 'reserve' ?
                                  'warning' : 'secondary') }}">
                        {{ $bien->statut }}
                    </span>
                </div>
                @empty
                <p class="text-muted text-center">Aucun bien</p>
                @endforelse
                <a href="{{ route('admin.biens') }}"
                   class="btn btn-sm mt-2"
                   style="background:#4ECDC4; color:white">
                    Gérer mes biens
                </a>
            </div>
        </div>
    </div>
</div>
@endsection