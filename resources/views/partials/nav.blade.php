<style>
    /* Navbar */
    .navbar {
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        background-color: rgba(0, 0, 0, 0.8);
        padding: 20px 5%;
        display: flex;
        justify-content: space-between;
        align-items: center;
        z-index: 1000;
        transition: all 0.3s ease;
    }

    .navbar.scrolled {
        background-color: rgba(0, 0, 0, 0.95);
        padding: 15px 5%;
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

    .nav-links {
        display: flex;
        gap: 30px;
    }

    .nav-links a {
        color: white;
        text-decoration: none;
        font-size: 1.1rem;
        transition: color 0.3s ease;
        position: relative;
    }

    .nav-links a:hover {
        color: var(--primary);
    }

    .nav-links a::after {
        content: '';
        position: absolute;
        bottom: -5px;
        left: 0;
        width: 0;
        height: 2px;
        background-color: var(--primary);
        transition: width 0.3s ease;
    }

    .nav-links a:hover::after {
        width: 100%;
    }

    .mobile-menu-btn {
        display: none;
        background: none;
        border: none;
        color: white;
        font-size: 1.5rem;
        cursor: pointer;
    }
</style>

<!-- Navbar -->
<nav class="navbar">
    <a href="{{route('home')}}" class="logo" style="display: flex; align-items: center; gap: 10px;">
        @if($settings && $settings->logo_path)
            <img src="{{ route('image.serve', ['folder' => 'logos', 'filename' => basename($settings->logo_path)]) }}" alt="Logo" style="height: 50px; border-radius: 5px;">
            <span style="color: white">Snack <span style="color: var(--primary)">El Madina</span></span>
        @else
            <span style="color: white">Snack <span style="color: var(--primary)">El Madina</span></span>
        @endif
    </a>
    <ul class="nav-links">
        <li><a href="{{route('home')}}">Accueil</a></li>
        @php $isAuthPage = request()->routeIs('login') || request()->routeIs('register'); @endphp
        @unless($isAuthPage)
        <li><a href="#specialties">Spécialités</a></li>
        <li><a href="#reviews">Avis</a></li>
        <li><a href="#contact">Contact</a></li>
        @endunless
        <li><a href="{{route('register')}}">Inscription</a></li>
        <li><a href="{{ route('login') }}">Connexion</a></li>
    </ul>
    <button class="mobile-menu-btn">
        <i class="fas fa-bars"></i>
    </button>
</nav>
