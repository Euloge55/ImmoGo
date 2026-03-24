@extends('layouts.app')
@section('title', 'Mes Réservations')

@section('content')
<div class="container py-5">

    <h3 class="fw-bold mb-4">
        <i class="fas fa-calendar-check me-2" style="color:#4ECDC4"></i>
        Mes Réservations
    </h3>

    @if($contrats->isEmpty())
        <div class="text-center py-5">
            <i class="fas fa-calendar fa-4x text-muted mb-3"></i>
            <h4 class="text-muted">Aucune réservation</h4>
            <a href="{{ route('biens.index') }}"
               class="btn fw-semibold mt-3"
               style="background:#4ECDC4; color:white; border-radius:10px">
                Voir les biens
            </a>
        </div>
    @else
        @foreach($contrats as $contrat)
        <div class="card border-0 rounded-4 shadow-sm mb-4">
            <div class="card-body p-4">
                <div class="row align-items-center">

                    <!-- INFO BIEN -->
                    <div class="col-md-4">
                        <h6 class="fw-bold mb-1">
                            {{ $contrat->bien->titre_bien ?? 'N/A' }}
                        </h6>
                        <small class="text-muted">
                            <i class="fas fa-map-marker-alt me-1"
                               style="color:#4ECDC4"></i>
                            {{ $contrat->bien->ville->nom_ville ?? 'N/A' }}
                        </small>
                        <br>
                        <span class="badge bg-info mt-1">
                            {{ $contrat->type_contrat }}
                        </span>
                    </div>

                    <!-- MONTANTS -->
                    <div class="col-md-4 text-center">
                        @php
                            $montantTotal = $contrat->type_contrat == 'location'
                                ? ($contrat->location->montant_total_location ?? 0)
                                : ($contrat->vente->montant_total_vente ?? 0);
                            $totalPaye = $contrat->paiements->sum('montant');
                            $solde = $montantTotal - $totalPaye;
                        @endphp
                        <p class="mb-1">
                            <small class="text-muted">Total</small><br>
                            <strong>{{ number_format($montantTotal, 0, ',', ' ') }} F</strong>
                        </p>
                        <p class="mb-1">
                            <small class="text-muted">Payé</small><br>
                            <strong style="color:#2ecc71">
                                {{ number_format($totalPaye, 0, ',', ' ') }} F
                            </strong>
                        </p>
                        <p class="mb-0">
                            <small class="text-muted">Solde restant</small><br>
                            <strong style="color:#e74c3c">
                                {{ number_format($solde, 0, ',', ' ') }} F
                            </strong>
                        </p>
                    </div>

                    <!-- STATUT ET PAIEMENT -->
                    <div class="col-md-4 text-end">
                        @if($contrat->statut_contrat == 'confirme')
                            <span class="badge bg-success mb-2 d-block">✓ Confirmé</span>
                        @elseif($contrat->statut_contrat == 'en_attente')
                            <span class="badge bg-warning text-dark mb-2 d-block">
                                En attente
                            </span>
                            @if($solde > 0)
                                <button class="btn btn-sm fw-semibold"
                                        style="background:#4ECDC4; color:white"
                                        data-bs-toggle="modal"
                                        data-bs-target="#modalPayer{{ $contrat->id_contrat }}">
                                    <i class="fas fa-credit-card me-1"></i>Payer
                                </button>
                            @endif
                        @else
                            <span class="badge bg-danger mb-2 d-block">Annulé</span>
                        @endif
                    </div>
                </div>
            </div>
        </div>

        <!-- MODAL PAIEMENT -->
        @if($contrat->statut_contrat == 'en_attente' && $solde > 0)
            <form action="{{ route('fedapay.solde') }}" method="POST">
                @csrf
                <input type="hidden" name="id_contrat"
                    value="{{ $contrat->id_contrat }}">
                <button type="submit"
                        class="btn btn-sm fw-semibold"
                        style="background:#4ECDC4; color:white">
                    <i class="fas fa-credit-card me-1"></i>
                    Payer solde ({{ number_format($solde, 0, ',', ' ') }} FCFA)
                </button>
            </form>
        @endif
        @endforeach
    @endif
</div>
@endsection