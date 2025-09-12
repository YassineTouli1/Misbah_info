<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Menus - Snack El Madina</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600;700&family=Playfair+Display:wght@700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link rel="stylesheet" href="<?php echo e(asset('css/profile.css')); ?>">
    <style>
        /* Styles généraux */
        body {
            font-family: 'Poppins', sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f5f5f5;
        }

        /* Styles pour les modals */
        .modal {
    position: fixed;
    z-index: 10000;
    left: 0;
    top: 0;
    width: 100%;
    height: 100%;
    display: flex;
    justify-content: center;
    align-items: center;
    /* Pour forcer l’alignement au centre même si un autre style interfère */
    text-align: center;
    margin-top: 15%;
}

.modal-content {
    background-color: #fefefe;
    border-radius: 10px;
    width: 90%;
    max-width: 400px;
    box-shadow: 0 4px 20px rgba(0,0,0,0.3);
    animation: modalSlideIn 0.3s ease-out;

    /* S’assurer que le modal est bien au centre */
    margin: auto;
}


        @keyframes modalSlideIn {
            from { transform: translateY(-50px); opacity: 0; }
            to { transform: translateY(0); opacity: 1; }
        }

        .modal-header {
            background: linear-gradient(135deg, #4CAF50, #45a049);
            color: white;
            padding: 20px;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .modal-header h2 {
            margin: 0;
            font-size: 1.5em;
        }

        .close {
            color: white;
            font-size: 28px;
            font-weight: bold;
            cursor: pointer;
            transition: opacity 0.3s;
        }

        .close:hover {
            opacity: 0.7;
        }

        .modal-body {
            padding: 30px 20px;
            text-align: center;
        }

        .success-icon {
            font-size: 4em;
            margin-bottom: 20px;
            color: #4CAF50;
        }

        .modal-body p {
            font-size: 1.1em;
            color: #333;
            margin-bottom: 20px;
        }

        .commande-details {
            background: #f8f9fa;
            padding: 15px;
            border-radius: 8px;
            margin: 20px 0;
        }

        .commande-details p {
            margin: 8px 0;
            font-size: 1em;
        }

        .modal-footer {
            padding: 20px;
            text-align: center;
            border-top: 1px solid #eee;
        }

        /* Styles des boutons */
        .btn-success, .btn-confirm {
            background: linear-gradient(135deg, #4CAF50, #45a049);
            color: white;
            border: none;
            padding: 12px 30px;
            border-radius: 25px;
            font-size: 1em;
            cursor: pointer;
            transition: all 0.3s;
            margin: 0 5px;
        }

        .btn-cancel {
            background: linear-gradient(135deg, #f44336, #d32f2f);
            color: white;
            border: none;
            padding: 12px 30px;
            border-radius: 25px;
            font-size: 1em;
            cursor: pointer;
            transition: all 0.3s;
            margin: 0 5px;
        }

        .btn-success:hover, .btn-confirm:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 15px rgba(76, 175, 80, 0.4);
        }

        .btn-cancel:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 15px rgba(244, 67, 54, 0.4);
        }

        /* Styles du panier */
        .cart-container {
            position: fixed;
            right: 20px;
            bottom: 20px;
            z-index: 9999;
        }

        .cart-toggle {
            background: linear-gradient(135deg, darkorange, darkorange);
            color: white;
            border: none;
            width: 60px;
            height: 60px;
            border-radius: 50%;
            font-size: 1.5em;
            cursor: pointer;
            box-shadow: 0 4px 10px rgba(0,0,0,0.2);
            display: flex;
            align-items: center;
            justify-content: center;
            position: relative;
            transition: transform 0.3s;
        }

        .cart-toggle:hover {
            transform: scale(1.05);
        }

        .cart-count {
            position: absolute;
            top: -5px;
            right: -5px;
            background: #ff4444;
            color: white;
            border-radius: 50%;
            width: 25px;
            height: 25px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 0.7em;
        }

        .cart-panel {
            position: fixed;
            right: 20px;
            bottom: 90px;
            width: 350px;
            max-height: 60vh;
            overflow-y: auto;
            background: #1c1b1b;
            color: white;
            border-radius: 10px;
            padding: 15px;
            box-shadow: 0 5px 15px rgba(0,0,0,0.3);
            z-index: 9998;
            display: none;
            transform: translateY(20px);
            opacity: 0;
            transition: all 0.3s ease;
        }

        .cart-panel.show {
            display: block;
            transform: translateY(0);
            opacity: 1;
        }

        .cart-title {
            margin: 0 0 15px 0;
            padding-bottom: 10px;
            border-bottom: 1px solid rgba(255,255,255,0.1);
        }

        .cart-items {
            max-height: 300px;
            overflow-y: auto;
            margin-bottom: 15px;
        }

        .cart-item {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 10px 0;
            border-bottom: 1px solid rgba(255,255,255,0.1);
        }

        .cart-item-name {
            font-weight: 500;
        }

        .cart-total {
            font-weight: bold;
            text-align: right;
            margin: 15px 0;
            font-size: 1.1em;
        }

        .cart-actions {
            display: flex;
            justify-content: space-between;
            gap: 10px;
        }

        .btn-cart {
            flex: 1;
            padding: 5px;
            border-radius: 5px;
            border: none;
            cursor: pointer;
            font-weight: bold;
            transition: all 0.2s;
        }

        .btn-clear {
            background: transparent;
            border: 1px solid red ;
            color: white;

        }

        .btn-checkout {
            background: darkorange;
            color: white;
        }

        .btn-cart:hover {
            opacity: 0.9;
            transform: translateY(-2px);
        }

        /* Styles des plats */
        .dish-item {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 15px 0;
            border-bottom: 1px solid #eee;
        }

        .dish-left {
            display: flex;
            align-items: center;
            gap: 15px;
        }

        .dish-image-container {
            width: 60px;
            height: 60px;
            border-radius: 50%;
            overflow: hidden;
        }

        .dish-image {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        .btn-add {
            background: none;
            border: none;
            color: darkorange;
            font-size: 1.2em;
            cursor: pointer;
            transition: transform 0.2s;
        }

        .btn-add:hover {
            transform: scale(1.1);
        }
    </style>
</head>
<body>
<!-- Navbar -->
<?php if (isset($component)) { $__componentOriginald77fa4736f55447df3aa13beefa4cc6d = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginald77fa4736f55447df3aa13beefa4cc6d = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.nav-profile','data' => []] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('nav-profile'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes([]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginald77fa4736f55447df3aa13beefa4cc6d)): ?>
<?php $attributes = $__attributesOriginald77fa4736f55447df3aa13beefa4cc6d; ?>
<?php unset($__attributesOriginald77fa4736f55447df3aa13beefa4cc6d); ?>
<?php endif; ?>
<?php if (isset($__componentOriginald77fa4736f55447df3aa13beefa4cc6d)): ?>
<?php $component = $__componentOriginald77fa4736f55447df3aa13beefa4cc6d; ?>
<?php unset($__componentOriginald77fa4736f55447df3aa13beefa4cc6d); ?>
<?php endif; ?>

<!-- Main Content -->
<div class="client-container">
    <section class="welcome-section">
        <div class="welcome-content">
            <h1 class="welcome-title">Notre Carte</h1>
            <p class="welcome-text">Découvrez nos spécialités maison</p>
        </div>
    </section>

    <div class="menu-section">
        <?php $__currentLoopData = $menus; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $menu): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <div class="menu-card">
                <div class="menu-header">
                    <h2 class="menu-title"><?php echo e($menu->title); ?></h2>
                </div>

                <?php
                    $categories = $menu->menuItems->groupBy('category.name');
                ?>

                <?php $__currentLoopData = $categories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $categoryName => $items): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <div class="category-section">
                        <h3 class="category-title">
                            <?php switch($categoryName):
                                case ('Entrées'): ?> <i class="fas fa-leaf"></i> <?php break; ?>
                                <?php case ('Plats principaux'): ?> <i class="fas fa-utensils"></i> <?php break; ?>
                                <?php case ('Desserts'): ?> <i class="fas fa-ice-cream"></i> <?php break; ?>
                                <?php case ('Boissons'): ?> <i class="fas fa-glass-whiskey"></i> <?php break; ?>
                                <?php default: ?> <i class="fas fa-circle"></i>
                            <?php endswitch; ?>
                            <?php echo e($categoryName); ?>

                        </h3>

                        <ul class="dish-list">
                            <?php $__empty_1 = true; $__currentLoopData = $items; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                                <li class="dish-item" data-id="<?php echo e($item->id); ?>" data-name="<?php echo e($item->name); ?>" data-price="<?php echo e($item->price); ?>">
                                    <div class="dish-left">
                                        <?php if($item->image): ?>
                                            <div class="dish-image-container">
                                                <img src="<?php echo e(asset('storage/' . $item->image)); ?>" alt="<?php echo e($item->name); ?>" class="dish-image">
                                            </div>
                                        <?php endif; ?>
                                        <div>
                                            <h4 class="dish-name"><?php echo e($item->name); ?></h4>
                                            <?php if($item->description): ?>
                                                <p class="dish-description"><?php echo e($item->description); ?></p>
                                            <?php endif; ?>
                                        </div>
                                    </div>
                                    <div class="dish-right">
                                        <span class="dish-price"><?php echo e(number_format($item->price, 2)); ?> DH</span>
                                        <button class="btn-add" title="Ajouter au panier">
                                            <i class="fas fa-plus-circle"></i>
                                        </button>
                                    </div>
                                </li>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                                <li class="no-items">Aucun plat dans cette catégorie</li>
                            <?php endif; ?>
                        </ul>
                    </div>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </div>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    </div>
</div>

<!-- Panier -->
<div class="cart-container">
    <button class="cart-toggle">
        <i class="fas fa-shopping-cart"></i>
        <span class="cart-count">0</span>
    </button>
    <div class="cart-panel">
        <h3 class="cart-title">Votre Panier</h3>
        <div class="cart-items"></div>
        <div class="cart-total">
            Total: <span class="total-amount">0.00</span> DH
        </div>
        <div class="cart-actions">
            <button class="btn-cart btn-clear">Vider</button>
            <form action="<?php echo e(route('storeCmd')); ?>" method="POST" id="commande-form">
                <?php echo csrf_field(); ?>
                <input type="hidden" name="user_id" value="<?php echo e(Auth::User()->id); ?>">
                <input type="hidden" name="total" id="total-input">
                <input type="hidden" name="items" id="items-input">
                <button type="submit" class="btn-cart btn-checkout">Commander</button>
            </form>
        </div>
    </div>
</div>

<!-- Modal de confirmation -->
<div id="confirmModal" class="modal" style="display: none;">
    <div class="modal-content">
        <div class="modal-header">
            <h2><i class="fas fa-question-circle"></i> Confirmer la commande</h2>
        </div>
        <div class="modal-body">
            <p>Êtes-vous sûr de vouloir passer cette commande ?</p>
        </div>
        <div class="modal-footer" style="justify-content: center;">
            <button class="btn-cancel" onclick="closeConfirmModal()">
                <i class="fas fa-times"></i> Annuler
            </button>
            <button class="btn-confirm" onclick="window.cart.confirmOrder()">
                <i class="fas fa-check"></i> Confirmer
            </button>
        </div>
    </div>
</div>

<!-- Modal de succès -->
<div id="successModal" class="modal" style="display: none;">
    <div class="modal-content">
        <div class="modal-header">
            <h2><i class="fas fa-check-circle"></i> Commande réussie !</h2>
            <span class="close">&times;</span>
        </div>
        <div class="modal-body">
            <div class="success-icon">
                <i class="fas fa-check-circle"></i>
            </div>
            <p id="successMessage">Votre commande a été passée avec succès !</p>
            <div class="commande-details">
                <p><strong><i class="fas fa-receipt"></i> Numéro :</strong> <span id="commandeId"></span></p>
                <p><strong><i class="fas fa-coins"></i> Total :</strong> <span id="commandeTotal"></span> DH</p>
            </div>
        </div>
        <div class="modal-footer">
            <button class="btn-success" onclick="closeSuccessModal()">
                <i class="fas fa-shopping-cart"></i> Continuer mes achats
            </button>
        </div>
    </div>
</div>
<script src="<?php echo e(asset('js/panier.js')); ?>"></script>

<script>
    // Fonctions globales pour les modals
    function closeConfirmModal() {
        document.getElementById('confirmModal').style.display = 'none';
    }

    function closeSuccessModal() {
        document.getElementById('successModal').style.display = 'none';
        // Recharger la page pour une nouvelle commande
        window.location.reload();
    }

    // Fermer les modals en cliquant en dehors
    window.addEventListener('click', function(event) {
        const confirmModal = document.getElementById('confirmModal');
        const successModal = document.getElementById('successModal');

        if (event.target === confirmModal) {
            closeConfirmModal();
        }
        if (event.target === successModal) {
            closeSuccessModal();
        }
    });

    // Fermer la modal de succès avec le bouton X
    document.querySelector('#successModal .close').addEventListener('click', closeSuccessModal);

    // Empêcher la propagation des clics dans les modals
    document.querySelectorAll('.modal-content').forEach(modal => {
        modal.addEventListener('click', e => e.stopPropagation());
    });
</script>
</body>
</html>
<?php /**PATH C:\Users\pc\Downloads\snack_app_rupture_stock\snack_app\resources\views/client/menus/menus.blade.php ENDPATH**/ ?>