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
            <h1 class="dashboard-title">Ajouter un plat</h1>
            <div class="dashboard-actions">
                <div class="dashboard-actions">
                    <a href="/menuItems" class="btn-orange">
                        Retour
                    </a>
                </div>
            </div>
        </div>

        <?php if(session('success')): ?>
            <div style="background:#e6ffed;color:#046c4e;border:1px solid #a7f3d0;padding:10px 12px;border-radius:8px;margin-bottom:16px;">
                <?php echo e(session('success')); ?>

            </div>
        <?php endif; ?>

        <?php if(session('error')): ?>
            <div style="background:#ffe6e6;color:#991b1b;border:1px solid #fecaca;padding:10px 12px;border-radius:8px;margin-bottom:16px;">
                <?php echo e(session('error')); ?>

            </div>
        <?php endif; ?>

        <?php if($errors->any()): ?>
            <div style="background:#fff7ed;color:#9a3412;border:1px solid #fed7aa;padding:10px 12px;border-radius:8px;margin-bottom:16px;">
                <ul style="margin:0; padding-left:18px;">
                    <?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $error): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <li><?php echo e($error); ?></li>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </ul>
            </div>
        <?php endif; ?>

        <form action="<?php echo e(route('menuItem.store')); ?>" method="POST" class="form-style" enctype="multipart/form-data">
            <?php echo csrf_field(); ?>

            <div class="form-group">
                <label for="name">Nom du plat</label>
                <input type="text" id="name" name="name" class="input" value="<?php echo e(old('name')); ?>" required>
            </div>

            <div class="form-group">
                <label for="price">Prix</label>
                <input type="number" id="price" name="price" class="input" step="0.01" value="<?php echo e(old('price')); ?>" required>
            </div>

            <!-- Nouveau champ Catégorie -->
            <div class="form-group">
                <label for="category">Catégorie</label>
                <select id="category" name="category_id" class="input" required>
                    <option value="">Sélectionnez une catégorie</option>
                    <?php $__currentLoopData = $categories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $category): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <option value="<?php echo e($category->id); ?>" <?php echo e(old('category_id') == $category->id ? 'selected' : ''); ?>>
                            <?php echo e($category->name); ?>

                        </option>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </select>
            </div>

            <div class="form-group">
                <label>Ingrédients disponibles :</label>
                <ul style="list-style: none; padding-left: 0;">
                    <?php $__currentLoopData = $ingredients; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $ingredient): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <li>
                            <label style="display: flex; align-items: center; gap: 10px;">
                                <input
                                    type="checkbox"
                                    name="ingredients[<?php echo e($ingredient->id); ?>][id]"
                                    value="<?php echo e($ingredient->id); ?>"
                                    class="ingredient-checkbox"
                                    onchange="toggleQuantityInput(this)"
                                    <?php echo e(old('ingredients.'.$ingredient->id.'.id') ? 'checked' : ''); ?>

                                >
                                <span style="flex-grow: 1;"><?php echo e($ingredient->name); ?></span>

                                <input
                                    type="number"
                                    name="ingredients[<?php echo e($ingredient->id); ?>][quantite]"
                                    step="0.01"
                                    min="0.01"
                                    placeholder="Qte utilisée"
                                    class="quantity-input"
                                    style="width: 80px;"
                                    value="<?php echo e(old('ingredients.'.$ingredient->id.'.quantite')); ?>"
                                    <?php echo e(old('ingredients.'.$ingredient->id.'.id') ? '' : 'disabled'); ?>

                                    <?php echo e(old('ingredients.'.$ingredient->id.'.id') ? 'required' : ''); ?>

                                >

                                <span class="stock-badge">
                                 Stock: <?php echo e($ingredient->quantite); ?> <?php echo e($ingredient->unite ?? 'unités'); ?>

        </span>
                            </label>
                        </li>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

                    <script>
                        function toggleQuantityInput(checkbox) {
                            const quantityInput = checkbox.closest('label').querySelector('.quantity-input');
                            const isChecked = checkbox.checked;
                            quantityInput.disabled = !isChecked;
                            quantityInput.required = isChecked; // require quantity if selected
                            if (!isChecked) {
                                quantityInput.value = '';
                            } else {
                                quantityInput.focus();
                            }
                        }

                        // If page reloads with validation errors, re-enable required for any checked items
                        window.addEventListener('DOMContentLoaded', function() {
                            document.querySelectorAll('.ingredient-checkbox').forEach(function(cb) {
                                if (cb.checked) {
                                    toggleQuantityInput(cb);
                                }
                            });
                        });
                    </script>
                </ul>
            </div>

            <div class="form-group">
                <label for="image">Image du plat</label>
                <input type="file" id="image" name="image" class="input" accept="image/*" required>
            </div>

            <div class="form-group">
                <button type="submit" class="btn-orange">
                    <i class="fas fa-plus"></i> Ajouter le plat
                </button>
            </div>
        </form>
    </main>
</div>
</body>
</html>
<?php /**PATH C:\Users\pc\Downloads\snack_app_rupture_stock\snack_app\resources\views/dashboard/menuItem/addMenuItem.blade.php ENDPATH**/ ?>