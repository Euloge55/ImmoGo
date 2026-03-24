@extends('layouts.admin')
@section('title', 'Gestion des Clients')

@section('content')

<h4 class="fw-bold mb-4">Tous les Clients</h4>

<div class="card border-0 rounded-4 shadow-sm">
    <div class="card-body p-4">
        <div class="table-responsive">
            <table class="table table-hover">
                <thead class="table-light">
                    <tr>
                        <th>Nom</th>
                        <th>Prénom</th>
                        <th>Email</th>
                        <th>Téléphone</th>
                        <th>Inscrit le</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($clients as $client)
                    <tr>
                        <td class="fw-semibold">{{ $client->nom_client }}</td>
                        <td>{{ $client->prenom_client }}</td>
                        <td>{{ $client->email }}</td>
                        <td>{{ $client->tel_client }}</td>
                        <td>{{ $client->created_at->format('d/m/Y') }}</td>
                        <td>
                            <form action="{{ route('superadmin.clients.supprimer',
                                          $client->id_client) }}"
                                  method="POST" class="d-inline"
                                  onsubmit="return confirm('Supprimer ce client ?')">
                                @csrf @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-outline-danger">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </form>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="text-center text-muted py-4">
                            Aucun client
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        {{ $clients->links() }}
    </div>
</div>
@endsection