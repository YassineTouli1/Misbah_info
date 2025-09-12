<!DOCTYPE html>
<html lang="fr">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Liste des Avis - Snack El Madina</title>
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <link rel="stylesheet" href="{{ asset('css/dashboard.css') }}">
        <link rel="stylesheet" href="{{ asset('css/nav.css') }}">
        <link rel="stylesheet" href="{{ asset('css/profile.css') }}">
        <link rel="stylesheet" href="{{ asset('css/ReviewTable.css') }}">
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

<x-nav-profile/>
<div class="container">
    <div class="table-header">
        <h2>Liste des Avis</h2>
        <a href="{{ route('client.review.add') }}" class="btn-orange">
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
        @foreach($reviews as $review)
            <tr>
                <td>{{ $review->name }}</td>
                <td>
                    <div class="rating">
                        <span class="stars">
                            @for($i = 1; $i <= 5; $i++)
                                @if($i <= $review->rating)
                                    <i class="fas fa-star"></i>
                                @else
                                    <i class="far fa-star"></i>
                                @endif
                            @endfor
                        </span>
                        <span>({{ $review->rating }}/5)</span>
                    </div>
                </td>
                <td>{{ Str::limit($review->review, 50) }}</td>
                <td>{{ $review->created_at->format('d/m/Y H:i') }}</td>
                <td>
    <div class="action-buttons">
        <a href="{{ route('review.edit', $review->id) }}" class="btn btn-warning btn-sm">
            <i class="fas fa-edit"></i> Modifier
        </a>

        <button class="btn btn-danger btn-sm delete-btn"
                data-resource-type="client/review"
                data-resource-id="{{ $review->id }}"
                data-resource-name="l'avis de {{ $review->name }}">
            <i class="fas fa-trash-alt"></i> Supprimer
        </button>
    </div>
</td>

            </tr>
        @endforeach
        </tbody>
    </table>
</div>

<x-deleteModal/>
<script src="{{ asset('js/deleteModal.js') }}"></script>


</body>
</html>
