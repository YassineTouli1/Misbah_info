<!DOCTYPE html>
<html lang="fr">
    <!-- Dans le head de votre layout principal -->
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
<x-head-dashboard/>
<body>
@include('partials.nav-manager')
<style>
    .table {
        width: 100%;
        margin-bottom: 1rem;
        color: #212529;
        background-color: #fff;
        border-collapse: collapse;
    }

    .table th,
    .table td {
        padding: 0.75rem;
        vertical-align: top;
        border-top: 1px solid #dee2e6;
    }

    .table thead th {
        vertical-align: bottom;
        border-bottom: 2px solid #dee2e6;
        background-color: #f8f9fa;
    }

    .table tbody tr:hover {
        background-color: rgba(0, 0, 0, 0.05);
    }

    .btn {
        display: inline-block;
        font-weight: 400;
        text-align: center;
        white-space: nowrap;
        vertical-align: middle;
        user-select: none;
        border: 1px solid transparent;
        padding: 0.375rem 0.75rem;
        font-size: 0.9rem;
        line-height: 1.5;
        border-radius: 0.25rem;
        transition: color 0.15s ease-in-out, background-color 0.15s ease-in-out,
                    border-color 0.15s ease-in-out, box-shadow 0.15s ease-in-out;
    }

    .btn-primary {
        color: #fff;
        background-color:darkorange;
    }

    .btn-primary:hover {
        background-color: orange;
    }

    .btn-edit {
        color: #fff;
        background-color: #17a2b8;
        border-color: #17a2b8;
    }

    .btn-edit:hover {
        background-color: #138496;
        border-color: #117a8b;
    }

    .btn-delete {
        color: #fff;
        background-color: #dc3545;
        border-color: #dc3545;
    }

    .btn-delete:hover {
        background-color: #c82333;
        border-color: #bd2130;
    }

    .action-buttons .btn {
        margin-right: 5px;
    }

    .alert {
        position: relative;
        padding: 0.75rem 1.25rem;
        margin-bottom: 1rem;
        border: 1px solid transparent;
        border-radius: 0.25rem;
    }

    .alert-success {
        color: #155724;
        background-color: #d4edda;
        border-color: #c3e6cb;
    }

    .alert-danger {
        color: #721c24;
        background-color: #f8d7da;
        border-color: #f5c6cb;
    }
    /* Style pour la modale */
    #deleteConfirmationModal {
        display: none;
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        z-index: 1050;
        overflow-x: hidden;
        overflow-y: auto;
        outline: 0;
    }

    /* Pour le fond sombre */
    .modal-backdrop {
        position: fixed;
        top: 0;
        left: 0;
        z-index: 1040;
        width: 100vw;
        height: 100vh;
        background-color: #000;
    }

    /* Pour centrer la modale */
    .modal-dialog-centered {
        display: flex;
        align-items: center;
        min-height: calc(100% - 1rem);
    }
    .modal {
        position: fixed;
        top: 50% !important;
        left: 50% !important;
        transform: translate(-50%, -50%) !important;
        margin: 0 !important;
    }

    /* Pour éviter le débordement sur les petits écrans */
    @media (min-width: 576px) {
        .modal-dialog {
            max-width: 500px;
            margin: 1.75rem auto;
        }
    }
</style>

</style>

<div class="dashboard-container" style="margin-top:70px;">
    <!-- Sidebar -->
    @include('partials.sideNav')

    <!-- Main Content -->
    <main class="main-content">
        <div class="dashboard-header">
            <h1 class="dashboard-title">Gestion des Catégories</h1>
            <div class="dashboard-actions">
                <a href="{{ route('category.create') }}" class="btn btn-primary">
                    <i class="fas fa-plus"></i> Nouvelle Catégorie
                </a>
            </div>
        </div>

        @if(session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif

        @if(session('error'))
            <div class="alert alert-danger">
                {{ session('error') }}
            </div>
        @endif

        <div class="table-responsive">
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Nom</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($categories as $category)
                        <tr>
                            <td>{{ $category->id }}</td>
                            <td>{{ $category->name }}</td>
                            <td class="action-buttons">
                                <a href="{{ route('category.edit', $category->id) }}" class="btn btn-sm btn-edit">
                                    <i class="fas fa-edit"></i> Modifier
                                </a>
                                <form action="{{ route('category.destroy', $category->id) }}" method="POST" style="display: inline-block;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="button" class="btn btn-sm btn-delete"
                                    onclick="confirmDelete('Voulez-vous vraiment supprimer cette catégorie ?', this)">
                                    <i class="fas fa-trash"></i> Supprimer
                                </button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="3" class="text-center">Aucune catégorie trouvée.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </main>
</div>

<!-- Modal de confirmation de suppression -->
<div class="modal fade" id="deleteConfirmationModal" tabindex="-1" aria-labelledby="modalTitle" aria-hidden="true" style="display: none;">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalTitle">Confirmation de suppression</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <p id="modalMessage">Voulez-vous vraiment supprimer cette catégorie ?</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Annuler</button>
                <button type="button" class="btn btn-danger" id="confirmDeleteBtn">Supprimer</button>
            </div>
        </div>
    </div>
</div>

<!-- Inclure jQuery et Bootstrap JS si ce n'est pas déjà fait -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>

<script>
   function confirmDelete(message, button) {
    const form = button.closest('form');
    document.getElementById('modalMessage').textContent = message;

    // Initialiser la modale
    const modalElement = document.getElementById('deleteConfirmationModal');
    const modal = new bootstrap.Modal(modalElement, {
        backdrop: 'static',
        keyboard: false
    });

    // Gérer le clic sur le bouton Supprimer
    const confirmBtn = document.getElementById('confirmDeleteBtn');
    const clickHandler = function() {
        form.submit();
    };

    // Supprimer les anciens écouteurs
    confirmBtn.removeEventListener('click', clickHandler);
    // Ajouter le nouvel écouteur
    confirmBtn.addEventListener('click', clickHandler);

    // Afficher la modale
    modal.show();

    // Forcer le positionnement
    modalElement.style.display = 'block';
    modalElement.classList.add('show');
    document.body.classList.add('modal-open');

    // Gérer la fermeture de la modale
    const closeButtons = modalElement.querySelectorAll('[data-bs-dismiss="modal"]');
    closeButtons.forEach(btn => {
        btn.addEventListener('click', function() {
            modal.hide();
            modalElement.style.display = 'none';
            modalElement.classList.remove('show');
            document.body.classList.remove('modal-open');
        });
    });
}

</script>

</body>
