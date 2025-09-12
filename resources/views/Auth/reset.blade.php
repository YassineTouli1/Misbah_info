<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Snack El Madina - Réinitialisation du mot de passe</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600;700&family=Playfair+Display:wght@700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link rel="stylesheet" href="{{ asset('css/login.css') }}">
</head>
<body>
<!-- Navbar -->
<x-nav/>
<!-- Reset Password Form -->
<div class="login-page">
    <div class="login-container">
        <h2 class="login-title">Réinitialiser le mot de passe</h2>
        <form method="POST" action="{{ route('password.update') }}">
            @csrf
            <x-form-error/>
            <input type="hidden" name="token" value="{{ $token }}">
            <input type="hidden" name="email" value="{{ $email }}">

            <div class="form-group">
                <label for="password">Nouveau mot de passe</label>
                <input type="password" name="password" id="password" class="form-control" placeholder="Nouveau mot de passe" required autofocus>
            </div>

            <div class="form-group">
                <label for="password_confirmation">Confirmer le mot de passe</label>
                <input type="password" name="password_confirmation" id="password_confirmation" class="form-control" placeholder="Confirmez le mot de passe" required>
            </div>

            <button type="submit" class="btn">
                <i class="fas fa-key"></i> Réinitialiser le mot de passe
            </button>
        </form>
    </div>
</div>
</body>
</html>