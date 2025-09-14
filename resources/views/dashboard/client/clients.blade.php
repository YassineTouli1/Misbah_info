<!DOCTYPE html>
<html lang="fr">
<x-head-dashboard/>
<body>

<style>

    .btn-orange {
        background-color: #ff9800; /* orange vif */
        color: white;
        font-weight: bold;
        padding: 12px 20px;
        border: none;
        border-radius: 12px;
        font-size: 16px;
        cursor: pointer;
        display: inline-flex;
        align-items: center;
        gap: 8px;
        text-decoration: none;
        box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        transition: background-color 0.3s ease;
    }

    .btn-orange:hover {
        background-color: #fb8c00; /* un peu plus foncé au hover */
    }
</style>

@include('partials.nav-manager')
<div class="dashboard-container" style="margin-top:70px;">
    <x-sideNav/>
    <main class="main-content">
        <div class="dashboard-header">
            <h1 class="dashboard-title">Tableau de Clients</h1>
            <div class="dashboard-actions">
                <a href="/addClient" class="btn-orange"><i class="fas fa-plus"></i> Nouveau Client</a>
            </div>
        </div>

        <section class="orders-section">
            <table class="orders-table">
                <thead>
                <tr>
                    <th>Nom Complet</th>
                    <th>Email</th>
                    <th>Numéro de téléphone</th>
                    <th>Action</th>
                </tr>
                </thead>
                <tbody>
                @foreach($clients as $client)
                    <tr>
                        <td>{{ $client->user->name }}</td>
                        <td>{{ $client->user->email }}</td>
                        <td>{{ $client->phone }}</td>
                        <td>
                            <button class="delete-btn"
                                    data-resource-type="clients"
                                    data-resource-id="{{ $client->id }}"
                                    data-resource-name="{{ $client->user->name }}">
                                <i class="fas fa-trash"></i>
                            </button>
                        </td>


                    </tr>
                @endforeach
                </tbody>
            </table>
        </section>
    </main>
</div>

<!-- Modal de confirmation -->
@include('partials.deleteModal')

<script src="{{asset('js/deleteModal.js')}}"></script>
</body>
</html>
