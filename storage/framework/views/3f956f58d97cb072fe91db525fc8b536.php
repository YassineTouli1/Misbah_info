<!-- Bootstrap CSS (in your <head>) -->
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
<!-- Bootstrap JS (before closing </body>) -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<!-- Font Awesome (for icons) -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">

<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
    <div class="container-fluid">
        <a class="navbar-brand d-flex align-items-center" href="<?php echo e(route('client.home')); ?>">
            <?php if($settings && $settings->logo_path): ?>
                <img src="<?php echo e(asset('storage/' . $settings->logo_path)); ?>" alt="Logo" class="me-2" style="height: 30px; border-radius: 5px;">
            <?php endif; ?>
            <span class="d-none d-sm-inline">Snack <span style="color: var(--primary)">El Madina</span></span>
        </a>

        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#clientNavbar">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="clientNavbar">
            <ul class="navbar-nav ms-auto mb-2 mb-lg-0 align-items-center">
                <!-- Navigation Links with spacing -->
                <li class="nav-item me-3">
                    <a href="<?php echo e(route('client.home')); ?>" class="nav-link text-white">
                        <i class="fas fa-home me-1"></i> Accueil
                    </a>
                </li>

                <li class="nav-item me-3">
                    <a href="<?php echo e(route('client.menus')); ?>" class="nav-link text-white">
                        <i class="fas fa-utensils me-1"></i> Menu
                    </a>
                </li>

                <li class="nav-item me-3">
                    <a href="<?php echo e(route('client.review')); ?>" class="nav-link text-white">
                        <i class="fas fa-star me-1"></i> Avis
                    </a>
                </li>

                <li class="nav-item me-3">
                    <a href="<?php echo e(route('client.home')); ?>" class="nav-link text-white">
                        <i class="fas fa-history me-1"></i> Mes Commandes
                    </a>
                </li>

                <!-- User Info -->
                <li class="nav-item d-none d-lg-block me-3">
                    <div class="d-flex align-items-center gap-2 ps-2">
                        <div class="user-avatar bg-darkorange rounded-circle text-white fw-bold text-center"
                             style="width: 28px; height: 28px; line-height: 28px;">
                            <?php echo e(strtoupper(Auth::user()->name[0])); ?>

                        </div>
                        <span class="text-white"><?php echo e(Auth::user()->name); ?></span>
                    </div>
                </li>

                <!-- Logout -->
                <li class="nav-item d-flex align-items-center">
                    <form action="<?php echo e(route('logout')); ?>" method="POST" class="m-0 h-100 d-flex align-items-center">
                        <?php echo csrf_field(); ?>
                        <button type="submit" class="btn btn-link nav-link text-white p-0">
                            <i class="fas fa-sign-out-alt me-1"></i> Déconnexion
                        </button>
                    </form>
                </li>
            </ul>
        </div>
    </div>
</nav>
<?php /**PATH C:\Users\pc\Downloads\snack_app_rupture_stock\snack_app\resources\views/components/nav-profile.blade.php ENDPATH**/ ?>