<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Snack El Madina - Inscription</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600;700&family=Playfair+Display:wght@700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link rel="stylesheet" href="css/register.css">

</head>
<body>
<!-- Navbar -->
@include('partials.nav')

<!-- Register Form -->
<div class="register-page">
    <div class="register-container">
        <div class="register-logo">Snack <span>El Madina</span></div>
        <h2 class="register-title">Créer un compte</h2>

        <form action="{{route('register')}}" method="POST">
            @csrf
            <!-- Error Message -->
            <div class="error-message">
                @if($errors->any())
                    <ul>
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                @endif
            </div>

            <!-- Full Name -->
            <div class="form-group">
                <label for="name">Nom complet</label>
                <input type="text" name="name" id="name" class="form-control" placeholder="Votre nom complet" value="{{ old('name') }}" required>
            </div>

            <!-- Email -->
            <div class="form-group">
                <label for="email">Email</label>
                <input type="email" name="email" id="email" class="form-control" placeholder="votre@email.com" value="{{ old('email') }}" required>
            </div>

            <!-- phone number -->

            <div class="form-group">
                <label for="phone_number">Numéro de téléphone</label>
                <input type="text" name="phone_number" id="phone_number" class="form-control" placeholder="0666****55" value="{{ old('phone_number') }}" required>
            </div>

            <!-- Password -->
            <div class="form-group">
                <label for="password">Mot de passe</label>
                <input type="password" name="password" id="password" class="form-control" placeholder="••••••••" required>
            </div>

            <!-- Confirm Password -->
            <div class="form-group">
                <label for="password_confirmation">Confirmer le mot de passe</label>
                <input type="password" name="password_confirmation" id="password_confirmation" class="form-control" placeholder="••••••••" required>
            </div>

            <button type="submit" class="btn">
                <i class="fas fa-user-plus"></i> Créer un compte
            </button>

            <div class="login-link">
                <p>Déjà un compte ? <a href="/login">Connectez-vous ici</a></p>
            </div>
        </form>
    </div>
</div>
</body>
</html>
