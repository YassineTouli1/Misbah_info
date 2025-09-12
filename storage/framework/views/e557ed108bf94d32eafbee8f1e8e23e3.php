<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Caisse - Snack El Madina</title>

    <!-- Fonts and Icons -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <!-- CSS -->
    <link rel="stylesheet" href="<?php echo e(asset('css/caisse.css')); ?>">
    <link rel="stylesheet" href="<?php echo e(asset('css/dashboard.css')); ?>">
    <link rel="stylesheet" href="<?php echo e(asset('css/profile.css')); ?>">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
.dashboard-container {
    display: flex;
    margin-top: 70px;
}
.main-container {
    flex: 1;
    min-width: 0;
}
.caisse-container {
    width: 100%;
    max-width: none;
}
</style>
</head>
<body>
    <?php if (isset($component)) { $__componentOriginal04a5844aa2c131e98d761afba2131f4a = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal04a5844aa2c131e98d761afba2131f4a = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.nav-manager','data' => []] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('nav-manager'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes([]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal04a5844aa2c131e98d761afba2131f4a)): ?>
<?php $attributes = $__attributesOriginal04a5844aa2c131e98d761afba2131f4a; ?>
<?php unset($__attributesOriginal04a5844aa2c131e98d761afba2131f4a); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal04a5844aa2c131e98d761afba2131f4a)): ?>
<?php $component = $__componentOriginal04a5844aa2c131e98d761afba2131f4a; ?>
<?php unset($__componentOriginal04a5844aa2c131e98d761afba2131f4a); ?>
<?php endif; ?>
    <div class="dashboard-container">
        <?php if (isset($component)) { $__componentOriginal78d8c7db6c5893be0ede686b1228d1e6 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal78d8c7db6c5893be0ede686b1228d1e6 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.sideNav','data' => []] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('sideNav'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes([]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal78d8c7db6c5893be0ede686b1228d1e6)): ?>
<?php $attributes = $__attributesOriginal78d8c7db6c5893be0ede686b1228d1e6; ?>
<?php unset($__attributesOriginal78d8c7db6c5893be0ede686b1228d1e6); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal78d8c7db6c5893be0ede686b1228d1e6)): ?>
<?php $component = $__componentOriginal78d8c7db6c5893be0ede686b1228d1e6; ?>
<?php unset($__componentOriginal78d8c7db6c5893be0ede686b1228d1e6); ?>
<?php endif; ?>
        <div class="main-container">
            <div class="caisse-container">
                <div class="caisse-header">
                    <h1 class="caisse-title">
                        <i class="fas fa-cash-register"></i> Caisse
                    </h1>

                    <div class="ajout-vider-caisse">
                        <!-- Ajouter montant -->
                        <button type="button" class="ajouter" data-bs-toggle="modal" data-bs-target="#ajouterMontantModal">
                            <i class="fas fa-plus-circle"></i> ajouter montant
                        </button>

                        <!-- Tirer montant -->
                        <button type="button" class="vider" data-bs-toggle="modal" data-bs-target="#tirerMontantModal">
                            <i class="fas fa-minus-circle"></i> tirer montant
                        </button>
                    </div>

                    <div class="caisse-total">
                        <i class="fas fa-coins"></i>
                        <span>
                            <?php if($caisse): ?>
                                <?php echo e(number_format($caisse->montant, 2)); ?> DH
                            <?php else: ?>
                                0.00 DH
                            <?php endif; ?>
                        </span>
                    </div>
                </div>

                <?php if(session('success')): ?>
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        <i class="fas fa-check-circle"></i> <?php echo e(session('success')); ?>

                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                <?php endif; ?>

                <?php if(session('error')): ?>
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        <i class="fas fa-exclamation-triangle"></i> <?php echo e(session('error')); ?>

                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                <?php endif; ?>

                <div class="caisse-content">
                    <!-- Filtres et recherche -->
                    <div class="filters-section mb-4">
                        <form method="GET" action="<?php echo e(route('manager.caisse')); ?>" class="row g-3">
                            <div class="col-md-2">
                                <select name="type" class="form-select">
                                    <option value="">Tous les types</option>
                                    <option value="ajout" <?php echo e($type == 'ajout' ? 'selected' : ''); ?>>Ajouts</option>
                                    <option value="retour" <?php echo e($type == 'retour' ? 'selected' : ''); ?>>Retours</option>
                                </select>
                            </div>
                            <div class="col-md-2">
                                <input type="date" name="date_debut" class="form-control" value="<?php echo e($dateDebut); ?>" placeholder="Date début">
                            </div>
                            <div class="col-md-2">
                                <input type="date" name="date_fin" class="form-control" value="<?php echo e($dateFin); ?>" placeholder="Date fin">
                            </div>

                        </form>
                    </div>

                    <!-- Transactions -->
                    <div class="transactions">
                        <div class="transactions-header d-flex justify-content-between align-items-center">
                            <h3>Historique des Transactions</h3>
                            <span class="badge bg-primary"><?php echo e($transactions->total()); ?> transactions</span>
                        </div>

                        <?php if($transactions->count() > 0): ?>
                            <div class="transaction-list">
                                <?php $__currentLoopData = $transactions; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $transaction): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <div class="transaction-item">
                                        <div class="transaction-info">
                                            <div class="transaction-header">
                                                <strong><?php echo e($transaction->reference); ?></strong>
                                                <span class="badge bg-<?php echo e($transaction->type == 'ajout' ? 'success' : 'danger'); ?>">
                                                    <?php echo e($transaction->type_label); ?>

                                                </span>
                                            </div>
                                            <div class="transaction-details">
                                                <small><?php echo e($transaction->date_formatted); ?></small>
                                                <br>
                                                <small class="text-muted"><?php echo e($transaction->description); ?></small>
                                                <?php if($transaction->commande): ?>
                                                    <br>
                                                    <small class="text-info">
                                                        <i class="fas fa-shopping-cart"></i>
                                                        Commande #<?php echo e($transaction->commande->id); ?>

                                                    </small>
                                                <?php endif; ?>
                                            </div>
                                            <div class="transaction-user">
                                                <small class="text-muted">
                                                    <i class="fas fa-user"></i> <?php echo e($transaction->user->name); ?>

                                                </small>
                                            </div>
                                        </div>
                                        <div class="transaction-amount">
                                            <div class="amount <?php echo e(in_array($transaction->type, ['retour', 'tirage']) ? 'text-danger' : 'text-success'); ?>">
                                                <?php echo e(in_array($transaction->type, ['retour', 'tirage']) ? '-' : '+'); ?><?php echo e($transaction->montant_formatted); ?>

                                            </div>
                                            <div class="balance-info">
                                                <small class="text-muted">
                                                    Solde: <?php echo e($transaction->solde_apres_formatted); ?>

                                                </small>
                                            </div>
                                        </div>
                                    </div>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </div>

                            <!-- Pagination -->
                            <div class="pagination-wrapper mt-4">
                                <?php echo e($transactions->appends(request()->query())->links()); ?>

                            </div>
                        <?php else: ?>
                            <div class="no-transactions">
                                <div class="text-center py-5">
                                    <i class="fas fa-inbox fa-3x text-muted mb-3"></i>
                                    <h5>Aucune transaction trouvée</h5>
                                    <p class="text-muted">Aucune transaction ne correspond à vos critères de recherche.</p>
                                </div>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div> <!-- /.main-container -->
    </div> <!-- /.dashboard-container -->

    <!-- Modal Ajouter -->
    <div class="modal fade" id="ajouterMontantModal" tabindex="-1" aria-labelledby="ajouterMontantLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content p-3">
                <?php echo $__env->make('dashboard.Caisse.ajouter_pop_up', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
            </div>
        </div>
    </div>

    <!-- Modal Tirer -->
    <div class="modal fade" id="tirerMontantModal" tabindex="-1" aria-labelledby="tirerMontantLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content p-3">
                <?php echo $__env->make('dashboard.Caisse.tirer_caisse_pop_up', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
            </div>
        </div>
    </div>

    <!-- JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>
<?php /**PATH C:\Users\pc\Downloads\snack_app_rupture_stock\snack_app\resources\views/dashboard/Caisse/caisse.blade.php ENDPATH**/ ?>