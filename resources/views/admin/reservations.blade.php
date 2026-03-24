@extends('layouts.admin')
@section('title', 'Réservations')

@section('content')

<h4 class="fw-bold mb-4">Gestion des Réservations</h4>

<div class="card border-0 rounded-4 shadow-sm">
    <div class="card-body p-4">
        <div class="table-responsive">
            <table class="table table-hover">
                <thead class="table-light">
                    <tr>
                        <th>Réf</th>
                        <th>Client</th>
                        <th>Bien</th>
                        <th>Type</th>
                        <th>Montant</th>
                        <th>Payé</th>
                        <th>Statut</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($contrats as $contrat)
                    <tr>
                        <td class="fw-bold">#{{ $contrat->id_contrat }}</td>
                        <td>
                            {{ $contrat->client->prenom_client ?? '' }}
                            {{ $contrat->client->nom_client ?? 'N/A' }}
                        </td>
                        <td>{{ $contrat->bien->titre_bien ?? 'N/A' }}</td>
                        <td>
                            <span class="badge bg-info">{{ $contrat->type_contrat }}</span>
                        </td>
                        <td class="fw-bold">
                            @if($contrat->type_contrat == 'location' && $contrat->location)
                                {{ number_format($contrat->location->montant_total_location,
                                   0, ',', ' ') }} F
                            @elseif($contrat->vente)
                                {{ number_format($contrat->vente->montant_total_vente,
                                   0, ',', ' ') }} F
                            @endif
                        </td>
                        <td style="color:#4ECDC4" class="fw-bold">
                            {{ number_format($contrat->paiements->sum('montant'),
                               0, ',', ' ') }} F
                        </td>
                        <td>
                            @if($contrat->statut_contrat == 'confirme')
                                <span class="badge bg-success">Confirmé</span>
                            @elseif($contrat->statut_contrat == 'en_attente')
                                <span class="badge bg-warning text-dark">En attente</span>
                            @else
                                <span class="badge bg-danger">Annulé</span>
                            @endif
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="7" class="text-center text-muted py-4">
                            Aucune réservation
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        {{ $contrats->links() }}
    </div>
</div>
@endsection