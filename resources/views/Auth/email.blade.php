<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Snack El Madina - Mot de passe oublié</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600;700&family=Playfair+Display:wght@700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link rel="stylesheet" href="{{ asset('css/login.css') }}">
</head>
<body>
<!-- Navbar -->
@include('partials.nav')
<div class="login-page">
    <div class="login-container">
        <h2 class="login-title">Mot de passe oublié</h2>
        <form method="POST" action="{{ route('password.email') }}">
            @csrf
            <x-form-error/>
            <div class="form-group">
                <label for="email">Adresse Email</label>
                <input type="email" name="email" id="email" class="form-control" placeholder="votre@email.com" required autofocus>
            </div>
            <button type="submit" class="btn">
                <i class="fas fa-paper-plane"></i> Envoyer le lien de réinitialisation
            </button>
        </form>
    </div>
</div>
</body>
</html>