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
<div class="dashboard-container" style="margin-top:70px;">
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
    <main class="main-content">
        <div class="dashboard-header">
            <h1 class="dashboard-title">Les Menus</h1>
            <div class="dashboard-actions">
                <a href="/menuItems" class="btn-orange">
                    <i class="fas fa-box"></i> Voir la liste des plats
                </a>
                <a href="/addMenu" class="btn-orange">
                    <i class="fas fa-utensils"></i> Créer un Menu
                </a>
            </div>
        </div>

        <div class="menus-grid">
            <?php $__currentLoopData = $menus; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $menu): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <div class="menu-card">
                    <div class="menu-header">
                        <h2 class="menu-title"><?php echo e($menu->title); ?></h2>
                        <span class="menu-availability <?php echo e($menu->available ? 'menu-available' : 'menu-unavailable'); ?>">
                            <?php echo e($menu->available ? 'Disponible' : 'Indisponible'); ?>

                        </span>
                    </div>

                    <div class="menu-items-container">
                        <h3 class="menu-items-title">Plats dans ce menu :</h3>

                        <?php if($menu->menuItems->count()): ?>
                            <ul class="menu-items-list">
                                <?php $__currentLoopData = $menu->menuItems; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <li class="menu-item">
                                        <img src="<?php echo e(asset('storage/'.$item->image)); ?>"
                                             alt="<?php echo e($item->name); ?>"
                                             class="menu-item-image"
                                             onerror="this.onerror=null;this.src='<?php echo e(asset('images/placeholder.png')); ?>';">
                                        <div class="menu-item-details">
                                            <div class="menu-item-name"><?php echo e($item->name); ?></div>
                                            <div class="menu-item-price"><?php echo e($item->price); ?> MAD</div>
                                        </div>
                                    </li>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </ul>
                        <?php else: ?>
                            <div class="empty-menu">Aucun plat dans ce menu.</div>
                        <?php endif; ?>
                    </div>

                    <div class="menu-footer">
                        <div class="menu-total-items">
                            <?php echo e($menu->menuItems->count()); ?> plats
                        </div>
                        <div class="menu-actions">
                            <a href="/editMenu/<?php echo e($menu->id); ?>" class="btn btn-sm btn-edit-menu">
                                <i class="fas fa-edit"></i> Modifier
                            </a>
                            <button class="delete-btn"
                                    data-resource-type="deleteMenu"
                                    data-resource-id="<?php echo e($menu->id); ?>"
                                    data-resource-name="<?php echo e($menu->title); ?>">
                                <i class="fas fa-trash"></i>
                            </button>
                        </div>
                    </div>
                </div>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </div>
    </main>
</div>
<?php if (isset($component)) { $__componentOriginal8a5e48cfa46a2ffe6117e8f6550e02d1 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal8a5e48cfa46a2ffe6117e8f6550e02d1 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.deleteModal','data' => []] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('deleteModal'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes([]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal8a5e48cfa46a2ffe6117e8f6550e02d1)): ?>
<?php $attributes = $__attributesOriginal8a5e48cfa46a2ffe6117e8f6550e02d1; ?>
<?php unset($__attributesOriginal8a5e48cfa46a2ffe6117e8f6550e02d1); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal8a5e48cfa46a2ffe6117e8f6550e02d1)): ?>
<?php $component = $__componentOriginal8a5e48cfa46a2ffe6117e8f6550e02d1; ?>
<?php unset($__componentOriginal8a5e48cfa46a2ffe6117e8f6550e02d1); ?>
<?php endif; ?>
<script src="<?php echo e(asset('js/deleteModal.js')); ?>"></script>
</body>
</html>
<?php /**PATH C:\Users\pc\Downloads\snack_app_rupture_stock\snack_app\resources\views/dashboard/menu/menu.blade.php ENDPATH**/ ?>