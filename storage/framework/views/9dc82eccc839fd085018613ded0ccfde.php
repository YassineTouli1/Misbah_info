<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Manager - Snack El Madina</title>
    <!-- CSRF Token -->
    <meta name="csrf-token" content="<?php echo e(csrf_token()); ?>">

    <!-- Fonts and Icons -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600;700&family=Playfair+Display:wght@700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">

    <link rel="stylesheet" href="<?php echo e(asset('css/dashboard.css')); ?>">
    <link rel="stylesheet" href="<?php echo e(asset('css/nav.css')); ?>">
    <link rel="stylesheet" href="<?php echo e(asset('css/profile.css')); ?>">

    <style>
        .edit-form {
            max-width: 600px;
            margin: 2rem auto;
            padding: 2rem;
            background: white;
            border-radius: 12px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            font-family: 'Poppins', sans-serif;
        }

        .form-title {
            font-size: 1.5rem;
            font-weight: 600;
            margin-bottom: 1.5rem;
            color: #333;
            text-align: center;
        }

        .form-group {
            margin-bottom: 1.5rem;
        }

        .form-group label {
            display: block;
            font-size: 0.9rem;
            color: #555;
            margin-bottom: 0.5rem;
            font-weight: 500;
        }

        .form-group input,
        .form-group textarea,
        .form-group select {
            width: 100%;
            padding: 0.75rem;
            border: 1px solid #ddd;
            border-radius: 8px;
            font-size: 1rem;
            transition: border-color 0.3s;
        }

        .form-group input:focus,
        .form-group textarea:focus,
        .form-group select:focus {
            border-color: #4CAF50;
            outline: none;
        }

        .btn-group {
            display: flex;
            justify-content: space-between;
            margin-top: 2rem;
        }

        .btn-update {
            background-color: darkorange;
            color: white;
            border: none;
            padding: 0.75rem 1.5rem;
            border-radius: 8px;
            font-size: 1rem;
            cursor: pointer;
            transition: background-color 0.3s;
            font-weight: 600;
        }

        .btn-update:hover {
            background-color: orange;
        }

        .btn-back {
            background-color: #f1f1f1;
            color: #333;
            border: none;
            padding: 0.75rem 1.5rem;
            border-radius: 8px;
            font-size: 1rem;
            cursor: pointer;
            transition: background-color 0.3s;
            text-decoration: none;
            text-align: center;
            font-weight: 600;
        }

        .btn-back:hover {
            background-color: #ddd;
        }

        .rating-options {
            display: flex;
            gap: 0.5rem;
            flex-wrap: wrap;
        }

        .rating-option {
            flex: 1;
            min-width: 100px;
            padding: 0.5rem;
            border: 1px solid #ddd;
            border-radius: 8px;
            cursor: pointer;
            transition: all 0.3s;
            text-align: center;
            display: flex;
            flex-direction: column;
            align-items: center;
        }

        .rating-option:hover {
            background-color: #f9f9f9;
        }

        .rating-option.selected {
            background-color: #e8f5e9;
            border-color: #4CAF50;
        }

        .star-rating {
            color: #FFD700;
            font-size: 1.2rem;
            margin-bottom: 0.25rem;
        }

        .rating-label {
            font-size: 0.8rem;
        }

        .container {
            margin-top: 100px;
        }

        .logo {
            font-size: 1.8rem;
            color: white;
            font-family: 'Playfair Display', serif;
            text-decoration: none;
        }

        .logo span {
            color: var(--primary);
        }

        @media (max-width: 600px) {
            .rating-options {
                flex-direction: column;
            }
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

<div class="container">
    <form action="<?php echo e(route('review.store')); ?>" method="POST" class="edit-form">
        <?php echo csrf_field(); ?>
        <h2 class="form-title">Donner votre avis</h2>

        <?php if(auth()->guard()->check()): ?>
            <input type="hidden" name="name" value="<?php echo e(Auth::user()->name); ?>">
        <?php endif; ?>

        <div class="form-group">
            <label>Note</label>
            <div class="rating-options">
                <label class="rating-option">
                    <input type="radio" name="rating" value="5" required hidden>
                    <span class="star-rating">★★★★★</span>
                    <span class="rating-label">Excellent</span>
                </label>
                <label class="rating-option">
                    <input type="radio" name="rating" value="4" hidden>
                    <span class="star-rating">★★★★☆</span>
                    <span class="rating-label">Très bien</span>
                </label>
                <label class="rating-option">
                    <input type="radio" name="rating" value="3" hidden>
                    <span class="star-rating">★★★☆☆</span>
                    <span class="rating-label">Bien</span>
                </label>
                <label class="rating-option">
                    <input type="radio" name="rating" value="2" hidden>
                    <span class="star-rating">★★☆☆☆</span>
                    <span class="rating-label">Moyen</span>
                </label>
                <label class="rating-option">
                    <input type="radio" name="rating" value="1" hidden>
                    <span class="star-rating">★☆☆☆☆</span>
                    <span class="rating-label">Médiocre</span>
                </label>
            </div>
        </div>

        <div class="form-group">
            <label for="comment">Votre avis</label>
            <textarea id="comment" name="comment" rows="4" placeholder="Entrez votre avis ici..." required></textarea>
        </div>

        <div class="btn-group">
            <button type="submit" class="btn-update">
                <i class="fas fa-check"></i> Envoyer l'avis
            </button>
            <a href="#" class="btn-back">Retour</a>
        </div>
    </form>
</div>

<script>
    // Add selected class to rating options when clicked
    document.querySelectorAll('.rating-option').forEach(option => {
        option.addEventListener('click', function() {
            document.querySelectorAll('.rating-option').forEach(opt => {
                opt.classList.remove('selected');
            });
            this.classList.add('selected');
            this.querySelector('input').checked = true;
        });
    });
</script>
</body>
</html>
<?php /**PATH C:\Users\pc\Downloads\snack_app_rupture_stock\snack_app\resources\views/client/review/addReview.blade.php ENDPATH**/ ?>