<!DOCTYPE html>
<html lang="fr">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Liste des Avis - Snack El Madina</title>
        <meta name="csrf-token" content="<?php echo e(csrf_token()); ?>">
        <link rel="stylesheet" href="<?php echo e(asset('css/dashboard.css')); ?>">
        <link rel="stylesheet" href="<?php echo e(asset('css/nav.css')); ?>">
        <link rel="stylesheet" href="<?php echo e(asset('css/profile.css')); ?>">
        <link rel="stylesheet" href="<?php echo e(asset('css/ReviewTable.css')); ?>">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

</head>
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
<div class="container">
    <div class="table-header">
        <h2>Liste des Avis</h2>
        <a href="<?php echo e(route('client.review.add')); ?>" class="btn-orange">
            <i class="fas fa-plus"></i> Ajouter un avis
        </a>
    </div>

    <table class="orders-table">
        <thead>
        <tr>
            <th>Nom</th>
            <th>Note</th>
            <th>Avis</th>
            <th>Date</th>
            <th>Actions</th>
        </tr>
        </thead>
        <tbody>
        <?php $__currentLoopData = $reviews; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $review): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <tr>
                <td><?php echo e($review->name); ?></td>
                <td>
                    <div class="rating">
                        <span class="stars">
                            <?php for($i = 1; $i <= 5; $i++): ?>
                                <?php if($i <= $review->rating): ?>
                                    <i class="fas fa-star"></i>
                                <?php else: ?>
                                    <i class="far fa-star"></i>
                                <?php endif; ?>
                            <?php endfor; ?>
                        </span>
                        <span>(<?php echo e($review->rating); ?>/5)</span>
                    </div>
                </td>
                <td><?php echo e(Str::limit($review->review, 50)); ?></td>
                <td><?php echo e($review->created_at->format('d/m/Y H:i')); ?></td>
                <td>
    <div class="action-buttons">
        <a href="<?php echo e(route('review.edit', $review->id)); ?>" class="btn btn-warning btn-sm">
            <i class="fas fa-edit"></i> Modifier
        </a>

        <button class="btn btn-danger btn-sm delete-btn"
                data-resource-type="client/review"
                data-resource-id="<?php echo e($review->id); ?>"
                data-resource-name="l'avis de <?php echo e($review->name); ?>">
            <i class="fas fa-trash-alt"></i> Supprimer
        </button>
    </div>
</td>

            </tr>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </tbody>
    </table>
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
<?php /**PATH C:\Users\pc\Downloads\snack_app_rupture_stock\snack_app\resources\views/client/review/indexReview.blade.php ENDPATH**/ ?>