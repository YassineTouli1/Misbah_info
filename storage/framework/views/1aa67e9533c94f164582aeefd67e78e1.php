<!DOCTYPE html>
<html lang="fr">
<?php if (isset($component)) { $__componentOriginal9842cc6ca3f5fddb40f97c5a2fabbd60 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal9842cc6ca3f5fddb40f97c5a2fabbd60 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.head-dashboard','data' => []] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('head-dashboard'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes([]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal9842cc6ca3f5fddb40f97c5a2fabbd60)): ?>
<?php $attributes = $__attributesOriginal9842cc6ca3f5fddb40f97c5a2fabbd60; ?>
<?php unset($__attributesOriginal9842cc6ca3f5fddb40f97c5a2fabbd60); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal9842cc6ca3f5fddb40f97c5a2fabbd60)): ?>
<?php $component = $__componentOriginal9842cc6ca3f5fddb40f97c5a2fabbd60; ?>
<?php unset($__componentOriginal9842cc6ca3f5fddb40f97c5a2fabbd60); ?>
<?php endif; ?>
<meta name="csrf-token" content="<?php echo e(csrf_token()); ?>">
<style>
/* Forcer le centrage vertical de la modale Bootstrap */
.modal.show {
    display: flex !important;
    align-items: center;
    justify-content: center;
}
.modal-dialog {
    margin: 0 auto;
}
.orders-table {
    width: 100%;
    border-collapse: separate;
    border-spacing: 0 10px;
    font-size: 1.05rem;
}
.orders-table th, .orders-table td {
    background: #fff;
    padding: 14px 18px;
    vertical-align: middle;
    border: none;
}
.orders-table th {
    color: #ff6600;
    font-weight: 700;
    font-size: 1.08rem;
    background: #f8f9fa;
    border-bottom: 2px solid #eee;
}
.orders-table tr {
    box-shadow: 0 2px 8px rgba(0,0,0,0.04);
    border-radius: 12px;
    transition: box-shadow 0.2s;
}
.orders-table tr:hover {
    box-shadow: 0 4px 16px rgba(0,0,0,0.10);
}
.badge, .badge-status {
    border-radius: 8px;
    padding: 4px 12px;
    font-size: 0.98rem;
    font-weight: 600;
    display: inline-block;
}
.badge-en_attente { background: #fff3cd; color: #856404; }
.badge-confirmee { background: #d1e7dd; color: #0f5132; }
.badge-en_preparation { background: #cff4fc; color: #055160; }
.badge-prete { background: #e2e3e5; color: #41464b; }
.badge-livree { background: #cfe2ff; color: #084298; }
.badge-annulee, .badge-retournee { background: #f8d7da; color: #842029; }
.btn, .btn-sm {
    border-radius: 8px !important;
    padding: 7px 18px !important;
    font-size: 1rem !important;
    margin-bottom: 4px;
    transition: background 0.2s, color 0.2s;
}
.btn-outline, .btn-primary, .btn-info, .btn-success, .btn-warning, .btn-danger {
    border: 1.5px solid #ff6600;
    color: #ff6600;
    background: #fff;
}
.btn-primary { background: #ff6600 !important; color: #fff !important; border: none !important; }
.btn-info { background: #17a2b8 !important; color: #fff !important; border: none !important; }
.btn-success { background: #28a745 !important; color: #fff !important; border: none !important; }
.btn-warning { background: #ffc107 !important; color: #fff !important; border: none !important; }
.btn-danger { background: #dc3545 !important; color: #fff !important; border: none !important; }
.btn-outline:hover {
    background: #ff6600 !important;
    color: #fff !important;
}
.orders-table td strong {
    font-size: 1.15rem;
    color: #ff6600;
}
.orders-table .text-muted {
    color: #aaa;
}
.orders-table ul {
    margin: 0;
    padding-left: 18px;
}
.action-btn-group {
    display: flex;
    flex-wrap: wrap;
    gap: 8px;
    align-items: center;
    justify-content: flex-start;
}
</style>
<body>
<!-- Navbar -->
<?php if (isset($component)) { $__componentOriginal04a5844aa2c131e98d761afba2131f4a = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal04a5844aa2c131e98d761afba2131f4a = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.nav-manager','data' => []] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('nav-manager'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes([]); ?> <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal04a5844aa2c131e98d761afba2131f4a)): ?>
<?php $attributes = $__attributesOriginal04a5844aa2c131e98d761afba2131f4a; ?>
<?php unset($__attributesOriginal04a5844aa2c131e98d761afba2131f4a); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal04a5844aa2c131e98d761afba2131f4a)): ?>
<?php $component = $__componentOriginal04a5844aa2c131e98d761afba2131f4a; ?>
<?php unset($__componentOriginal04a5844aa2c131e98d761afba2131f4a); ?>
<?php endif; ?>

<!-- Dashboard Container -->
<div class="dashboard-container">
    <!-- Sidebar -->
    <?php if (isset($component)) { $__componentOriginal78d8c7db6c5893be0ede686b1228d1e6 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal78d8c7db6c5893be0ede686b1228d1e6 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.sideNav','data' => []] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('sideNav'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes([]); ?> <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal78d8c7db6c5893be0ede686b1228d1e6)): ?>
<?php $attributes = $__attributesOriginal78d8c7db6c5893be0ede686b1228d1e6; ?>
<?php unset($__attributesOriginal78d8c7db6c5893be0ede686b1228d1e6); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal78d8c7db6c5893be0ede686b1228d1e6)): ?>
<?php $component = $__componentOriginal78d8c7db6c5893be0ede686b1228d1e6; ?>
<?php unset($__componentOriginal78d8c7db6c5893be0ede686b1228d1e6); ?>
<?php endif; ?>

    <!-- Main Content -->
    <main class="main-content">
        <div class="dashboard-header">
            <h1 class="dashboard-title">Gestion des Commandes</h1>
        </div>

        <?php if(session('success')): ?>
            <div class="alert alert-success">
                <?php echo e(session('success')); ?>

            </div>
        <?php endif; ?>

        <?php if(session('error')): ?>
            <div class="alert alert-danger">
                <?php echo e(session('error')); ?>

            </div>
        <?php endif; ?>

        <section class="orders-section">
            <div class="table-responsive">
                <table class="orders-table">
                    <thead>
                    <tr>
                        <th>ID</th>
                        <th>Client</th>
                        <th>Articles commandés</th>
                        <th>Total</th>
                        <th>Statut</th>
                        <th>Date</th>
                        <th>Actions</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php $__empty_1 = true; $__currentLoopData = $commandes; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $commande): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                        <tr data-commande-id="<?php echo e($commande->id); ?>">
                            <td>#<?php echo e($commande->id); ?></td>
                            <td>
                                <strong><?php echo e($commande->client->user->name ?? 'Client inconnu'); ?></strong><br>
                                <small><?php echo e($commande->client->user->email ?? ''); ?></small>
                            </td>
                            <td>
                                <?php if($commande->menuItems->count() > 0): ?>
                                    <ul class="list-unstyled">
                                        <?php $__currentLoopData = $commande->menuItems; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <li>
                                                <?php echo e($item->pivot->quantity); ?>x <?php echo e($item->nom ?? $item->name); ?> <small class="text-muted">(<?php echo e(number_format($item->pivot->price, 2)); ?>DH)</small>
                                            </li>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    </ul>
                                <?php else: ?>
                                    <span class="text-muted">Aucun article</span>
                                <?php endif; ?>
                                <?php if($commande->notes): ?>
                                    <div class="mt-2">
                                        <small class="text-info"><strong>Notes:</strong> <?php echo e($commande->notes); ?></small>
                                    </div>
                                <?php endif; ?>
                            </td>
                            <td>
                                <strong><?php echo e(number_format($commande->total, 2)); ?>DH</strong>
                                <?php if($commande->is_paid): ?>
                                    <br><span class="badge badge-success">Payé</span>
                                <?php else: ?>
                                    <br><span class="badge badge-warning">Non payé</span>
                                <?php endif; ?>
                            </td>
                            <td>
                                <span class="badge <?php echo e($commande->status_class); ?>">
                                    <?php echo e($commande->status_label); ?>

                                </span>
                            </td>
                            <td>
                                <?php echo e($commande->created_at->format('d/m/Y H:i')); ?>

                                <?php if($commande->date_livraison): ?>
                                    <br><small class="text-success">Livré: <?php echo e($commande->date_livraison->format('d/m/Y H:i')); ?></small>
                                <?php endif; ?>
                            </td>
                            <td>
                                <div class="action-btn-group" role="group">
                                    <?php if($commande->validee_par_client): ?>
                                        <span class="badge badge-success" style="background:#28a745; color:#fff;">Validée par client</span>
                                    <?php endif; ?>
                                    <?php if($commande->canBeCancelled()): ?>
                                        <?php if($commande->statut === 'en_attente'): ?>
                                            <button class="btn btn-sm btn-primary action-btn" 
                                                    data-action="confirmer" 
                                                    data-commande-id="<?php echo e($commande->id); ?>">
                                                <i class="fas fa-check"></i> Confirmer
                                            </button>
                                            <button class="btn btn-sm btn-info action-btn" 
                                                    data-action="en-preparation" 
                                                    data-commande-id="<?php echo e($commande->id); ?>">
                                                <i class="fas fa-utensils"></i> En préparation
                                            </button>
                                        <?php endif; ?>
                                        <?php if($commande->statut === 'confirmee'): ?>
                                            <button class="btn btn-sm btn-info action-btn" 
                                                    data-action="en-preparation" 
                                                    data-commande-id="<?php echo e($commande->id); ?>">
                                                <i class="fas fa-utensils"></i> En préparation
                                            </button>
                                            <button class="btn btn-sm btn-success action-btn" 
                                                    data-action="prete" 
                                                    data-commande-id="<?php echo e($commande->id); ?>">
                                                <i class="fas fa-check-double"></i> Prête
                                            </button>
                                            <button class="btn btn-sm btn-success action-btn" 
                                                    data-action="livrer" 
                                                    data-commande-id="<?php echo e($commande->id); ?>">
                                                <i class="fas fa-truck"></i> Livrer
                                            </button>
                                        <?php endif; ?>
                                        <?php if($commande->statut === 'en_preparation'): ?>
                                            <button class="btn btn-sm btn-success action-btn" 
                                                    data-action="prete" 
                                                    data-commande-id="<?php echo e($commande->id); ?>">
                                                <i class="fas fa-check-double"></i> Prête
                                            </button>
                                            <button class="btn btn-sm btn-success action-btn" 
                                                    data-action="livrer" 
                                                    data-commande-id="<?php echo e($commande->id); ?>">
                                                <i class="fas fa-truck"></i> Livrer
                                            </button>
                                        <?php endif; ?>
                                        <button class="btn btn-sm btn-danger action-btn" 
                                                data-action="annuler" 
                                                data-commande-id="<?php echo e($commande->id); ?>">
                                            <i class="fas fa-times"></i> Annuler
                                        </button>
                                    <?php endif; ?>
                                    <?php if($commande->statut === 'prete'): ?>
                                        <button class="btn btn-sm btn-success action-btn" 
                                                data-action="livrer" 
                                                data-commande-id="<?php echo e($commande->id); ?>">
                                            <i class="fas fa-truck"></i> Livrer
                                        </button>
                                    <?php endif; ?>
                                    <?php if($commande->statut === 'livree'): ?>
                                        <button class="btn btn-sm btn-warning action-btn" 
                                                data-action="retourner" 
                                                data-commande-id="<?php echo e($commande->id); ?>">
                                            <i class="fas fa-undo"></i> Retourner
                                        </button>
                                    <?php endif; ?>
                                </div>
                            </td>
                        </tr>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                        <tr>
                            <td colspan="7" class="text-center">Aucune commande trouvée</td>
                        </tr>
                    <?php endif; ?>
                    </tbody>
                </table>
            </div>

            <!-- Pagination -->
            <div class="d-flex justify-content-center mt-4">
                <?php echo e($commandes->links()); ?>

            </div>
        </section>
    </main>
</div>

<script>
console.log('JS commandes chargé');
let currentAction = null;
let currentCommandeId = null;

// Gestion des actions sur les commandes
// Quand on clique sur Annuler, on annule directement sans raison
    document.querySelectorAll('.action-btn').forEach(btn => {
        btn.addEventListener('click', function(event) {
            event.preventDefault();
            const action = this.dataset.action;
            const commandeId = this.dataset.commandeId;
            console.log('Click bouton action', action, commandeId);
            executeAction(action, commandeId); // Annule directement
        });
    });

    function executeAction(action, commandeId) {
        // Confirmation spéciale pour le retour
        // if (action === 'retourner') {
        //     if (!confirm('Êtes-vous sûr de vouloir retourner cette commande ? Le client sera remboursé et le montant sera retiré de la caisse.')) {
        //         return;
        //     }
        // }
        
        const url = `<?php echo e(route('commandes.annuler', ':id')); ?>`.replace(':id', commandeId);
        const method = 'PATCH';
        
        // Construire l'URL correcte selon l'action
        const actionUrls = {
            'confirmer': `<?php echo e(route('commandes.confirmer', ':id')); ?>`,
            'en-preparation': `<?php echo e(route('commandes.en-preparation', ':id')); ?>`,
            'prete': `<?php echo e(route('commandes.prete', ':id')); ?>`,
            'livrer': `<?php echo e(route('commandes.livrer', ':id')); ?>`,
            'annuler': `<?php echo e(route('commandes.annuler', ':id')); ?>`,
            'retourner': `<?php echo e(route('commandes.retourner', ':id')); ?>`
        };

        const finalUrl = actionUrls[action].replace(':id', commandeId);

        fetch(finalUrl, {
            method: 'PATCH',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            },
            body: null // Pas de raison pour l'annulation directe
        })
        .then(response => response.json())
        .then(data => {
            console.log('Réponse AJAX:', data);
            if (data.success) {
                showAlert('success', data.message);
                updateCommandeRow(commandeId, data);
            } else {
                showAlert('error', data.message || 'Erreur lors de l\'annulation.');
            }
        })
        .catch(error => {
            console.error('Erreur:', error);
            showAlert('error', 'Une erreur technique est survenue (réseau ou serveur).');
        });
    }

    function updateCommandeRow(commandeId, data) {
        const row = document.querySelector(`tr[data-commande-id='${commandeId}']`);
        if (!row) return;
        // Met à jour le badge de statut
        const statutCell = row.querySelector('td:nth-child(5) .badge, td:nth-child(5) .badge-status');
        if (statutCell && data.status_label) {
            statutCell.textContent = data.status_label;
            // Optionnel : changer la classe CSS selon le statut
            statutCell.className = 'badge badge-' + (data.statut || '');
        }
        // Met à jour les boutons d'action
        const actionsCell = row.querySelector('td:last-child .action-btn-group');
        if (actionsCell) {
            let html = '';
            // Générer les boutons selon le nouveau statut
            if (data.statut === 'en_attente') {
                html += `<button class="btn btn-sm btn-primary action-btn" data-action="confirmer" data-commande-id="${commandeId}"><i class="fas fa-check"></i> Confirmer</button>`;
                html += `<button class="btn btn-sm btn-info action-btn" data-action="en-preparation" data-commande-id="${commandeId}"><i class="fas fa-utensils"></i> En préparation</button>`;
                html += `<button class="btn btn-sm btn-danger action-btn" data-action="annuler" data-commande-id="${commandeId}"><i class="fas fa-times"></i> Annuler</button>`;
            } else if (data.statut === 'confirmee') {
                html += `<button class="btn btn-sm btn-info action-btn" data-action="en-preparation" data-commande-id="${commandeId}"><i class="fas fa-utensils"></i> En préparation</button>`;
                html += `<button class="btn btn-sm btn-success action-btn" data-action="prete" data-commande-id="${commandeId}"><i class="fas fa-check-double"></i> Prête</button>`;
                html += `<button class="btn btn-sm btn-success action-btn" data-action="livrer" data-commande-id="${commandeId}"><i class="fas fa-truck"></i> Livrer</button>`;
                html += `<button class="btn btn-sm btn-danger action-btn" data-action="annuler" data-commande-id="${commandeId}"><i class="fas fa-times"></i> Annuler</button>`;
            } else if (data.statut === 'en_preparation') {
                html += `<button class="btn btn-sm btn-success action-btn" data-action="prete" data-commande-id="${commandeId}"><i class="fas fa-check-double"></i> Prête</button>`;
                html += `<button class="btn btn-sm btn-success action-btn" data-action="livrer" data-commande-id="${commandeId}"><i class="fas fa-truck"></i> Livrer</button>`;
                html += `<button class="btn btn-sm btn-danger action-btn" data-action="annuler" data-commande-id="${commandeId}"><i class="fas fa-times"></i> Annuler</button>`;
            } else if (data.statut === 'prete') {
                html += `<button class="btn btn-sm btn-success action-btn" data-action="livrer" data-commande-id="${commandeId}"><i class="fas fa-truck"></i> Livrer</button>`;
            } else if (data.statut === 'livree') {
                html += `<button class="btn btn-sm btn-warning action-btn" data-action="retourner" data-commande-id="${commandeId}"><i class="fas fa-undo"></i> Retourner</button>`;
            } else if (data.statut === 'annulee' || data.statut === 'retournee') {
                // Plus d'action possible : on masque les boutons
                html += '';
            }
            actionsCell.innerHTML = html;
            // Réattacher les listeners sur les nouveaux boutons
            actionsCell.querySelectorAll('.action-btn').forEach(btn => {
                btn.addEventListener('click', function(event) {
                    event.preventDefault();
                    const action = this.dataset.action;
                    const commandeId = this.dataset.commandeId;
                    console.log('Click bouton action', action, commandeId);
                    executeAction(action, commandeId);
                });
            });
        }
    }

    function showAlert(type, message) {
        const alertClass = type === 'success' ? 'alert-success' : 'alert-danger';
        const alertHtml = `<div class="alert ${alertClass} alert-dismissible fade show" role="alert">
            ${message}
            <button type="button" class="close" data-dismiss="alert">
                <span>&times;</span>
            </button>
        </div>`;
        
        const alertContainer = document.querySelector('.dashboard-header');
        alertContainer.insertAdjacentHTML('afterend', alertHtml);
        
        // Auto-dismiss après 5 secondes
        setTimeout(() => {
            const alert = document.querySelector('.alert');
            if (alert) {
                alert.remove();
            }
        }, 5000);
    }
</script>

</body>
</html>
<?php /**PATH C:\Users\pc\Downloads\snack_app_rupture_stock\snack_app\resources\views/dashboard/Commande/commandes.blade.php ENDPATH**/ ?>