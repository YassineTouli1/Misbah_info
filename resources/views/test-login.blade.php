<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Test Connexion</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
</head>
<body>
    <h1>Test de Connexion</h1>
    
    <form action="/test-login" method="POST">
        @csrf
        <div>
            <label for="email">Email:</label>
            <input type="email" name="email" id="email" value="gerant@snack.com" required>
        </div>
        <div>
            <label for="password">Mot de passe:</label>
            <input type="password" name="password" id="password" value="password" required>
        </div>
        <button type="submit">Test Connexion</button>
    </form>
    
    <hr>
    
    <h2>Test avec le formulaire original</h2>
    <form action="/login" method="POST">
        @csrf
        <div>
            <label for="email2">Email:</label>
            <input type="email" name="email" id="email2" value="gerant@snack.com" required>
        </div>
        <div>
            <label for="password2">Mot de passe:</label>
            <input type="password" name="password" id="password2" value="password" required>
        </div>
        <button type="submit">Connexion Originale</button>
    </form>
    
    <hr>
    
    <h2>État de l'authentification</h2>
    <div id="auth-status">Chargement...</div>
    
    <script>
        // Vérifier l'état de l'authentification
        fetch('/test-auth')
            .then(response => response.json())
            .then(data => {
                document.getElementById('auth-status').innerHTML = 
                    '<pre>' + JSON.stringify(data, null, 2) + '</pre>';
            });
    </script>
</body>
</html> 