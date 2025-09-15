<!-- Bootstrap CSS (in your <head>) -->
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
<!-- Bootstrap JS (before closing </body>) -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<!-- Font Awesome (for icons) -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">

<nav class="navbar navbar-expand-lg navbar-dark fixed-top" style="background-color: var(--dark-bg); box-shadow: 0 2px 10px rgba(0,0,0,0.1); padding: 15px 5%;">
    <div class="container-fluid">
        <a class="navbar-brand d-flex align-items-center gap-2" href="{{ route('home') }}">
            @if($settings && $settings->logo_path)
                <img src="{{ route('image.serve', ['folder' => 'logos', 'filename' => basename($settings->logo_path)]) }}" alt="Logo" style="height: 50px; border-radius: 5px;">
            @endif
            <span style="color: white;">Snack <span style="color: var(--primary)">El Madina</span></span>
        </a>

        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#dashboardNavbar" aria-controls="dashboardNavbar" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="dashboardNavbar">
            <ul class="navbar-nav ms-auto d-flex align-items-lg-center gap-lg-4">
                <li class="nav-item">
                    <a class="nav-link" href="#"><i class="fas fa-bell"></i> Notifications</a>
                </li>
                <li class="nav-item d-flex align-items-center gap-2">
                    <div class="user-avatar d-flex align-items-center justify-content-center" style="width: 40px; height: 40px; background-color: var(--primary); border-radius: 50%; color: white; font-weight: bold;">
                        M
                    </div>
                    <span class="text-white">Manager</span>
                </li>
                <li class="nav-item">
                    <form action="{{ route('logout') }}" method="POST">
                        @csrf
                        <button type="submit" class="btn btn-link nav-link" style="color: white;">
                            <i class="fas fa-sign-out-alt"></i> Déconnexion
                        </button>
                    </form>
                </li>
            </ul>
        </div>
    </div>
</nav>
