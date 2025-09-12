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
                <?php $__currentLoopData = $clients; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $client): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <tr>
                        <td><?php echo e($client->user->name); ?></td>
                        <td><?php echo e($client->user->email); ?></td>
                        <td><?php echo e($client->phone); ?></td>
                        <td>
                            <button class="delete-btn"
                                    data-resource-type="clients"
                                    data-resource-id="<?php echo e($client->id); ?>"
                                    data-resource-name="<?php echo e($client->user->name); ?>">
                                <i class="fas fa-trash"></i>
                            </button>
                        </td>


                    </tr>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </tbody>
            </table>
        </section>
    </main>
</div>

<!-- Modal de confirmation -->
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
<?php /**PATH C:\Users\pc\Downloads\snack_app_rupture_stock\snack_app\resources\views/dashboard/client/clients.blade.php ENDPATH**/ ?>