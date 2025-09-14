<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Manager - Snack El Madina</title>

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <!-- Fonts and Icons -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600;700&family=Playfair+Display:wght@700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">

    <link rel="stylesheet" href="{{ asset('css/dashboard.css') }}">
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
@include('partials.nav-manager')

<div class="dashboard-container">
    <!-- Sidebar -->
    @include('partials.sideNav')

    <!-- Main content -->
    <div class="main-content">
        <form action="{{ route('admin.settings.update') }}" method="POST" enctype="multipart/form-data" class="add-client-form-section">
            @csrf
            @include('partials.form-error')
            <div class="form-style">

                <!-- Titre du Hero -->
                <div class="form-group">
                    <label for="hero_title">Titre du Hero :</label>
                    <input type="text" name="hero_title" id="hero_title" class="input" value="{{ $settings->hero_title ?? '' }}">
                </div>

                <!-- Sous-titre -->
                <div class="form-group">
                    <label for="hero_subtitle">Sous-titre :</label>
                    <input type="text" name="hero_subtitle" id="hero_subtitle" class="input" value="{{ $settings->hero_subtitle ?? '' }}">
                </div>

                <!-- Logo -->
                <div class="form-group">
                    <label for="image">Logo actuelle :</label><br>
                    @if($settings->logo_path)
                        <img src="{{ asset('storage/' . $settings->logo_path) }}" alt="Image actuelle" style="width: 100px; height: auto; margin-bottom: 10px; border-radius: 5px;">
                    @endif

                    <label for="image">Changer l’image :</label>
                    <input type="file" id="logo" name="logo" class="input">
                </div>

                <!-- Facebook -->
                <div class="form-group">
                    <label for="facebook_link">Lien Facebook :</label>
                    <input type="url" name="facebook_link" id="facebook_link" class="input" value="{{ $settings->facebook_link ?? '' }}">
                </div>

                <!-- Instagram -->
                <div class="form-group">
                    <label for="instagram_link">Lien Instagram :</label>
                    <input type="url" name="instagram_link" id="instagram_link" class="input" value="{{ $settings->instagram_link ?? '' }}">
                </div>

                <!-- WhatsApp -->
                <div class="form-group">
                    <label for="whatsapp_link">Lien WhatsApp :</label>
                    <input type="url" name="whatsapp_link" id="whatsapp_link" class="input" value="{{ $settings->whatsapp_link ?? '' }}">
                </div>

                <!-- phone -->
                <div class="form-group">
                    <label for="phone">Telephone :</label>
                    <input type="text" name="phone" id="phone" class="input" value="{{ $settings->phone ?? '' }}">
                </div>

                <!-- disponibilite -->
                <div class="form-group">
                    <label for="disponibilite">Ouverture :</label>
                    <input type="text" name="disponibilite" id="disponibilite" class="input" value="{{ $settings->disponibilite ?? '' }}">
                </div>

                <!-- adresse -->
                <div class="form-group">
                    <label for="adresse">Adresse :</label>
                    <input type="text" name="adresse" id="adresse" class="input" value="{{ $settings->adresse ?? '' }}">
                </div>

                <!-- Bouton Enregistrer -->
                <div class="form-submit-btn">
                    <button type="submit" class="btn-orange">
                        <i class="fas fa-save"></i> Enregistrer
                    </button>
                </div>
            </div>
        </form>
    </div>
</div>
</body>
