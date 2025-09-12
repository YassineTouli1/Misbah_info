<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Modifier votre avis</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body class="bg-light">

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
        box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        transition: background-color 0.3s ease;
    }

    .btn-orange:hover {
        background-color: #fb8c00; /* un peu plus foncé au hover */
    }
</style>

<x-nav-profile/>
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-12 col-md-8 col-lg-5">
            <div class="card shadow">
                <div class="card-body">
                    <h1 class="h4 mb-4 text-center">Modifier votre avis</h1>
                    <form method="POST" action="{{ route('review.update', $review->id) }}">
                        @csrf
                        <x-form-error/>
                        @method('PUT')
                        <div class="mb-3">
                            <label class="form-label d-block mb-2">Votre note</label>
                            <div class="btn-group w-100" role="group">
                                @for($i = 5; $i >= 1; $i--)
                                    <input type="radio" class="btn-check" name="rating" id="star{{ $i }}" value="{{ $i }}" autocomplete="off" {{ $review->rating == $i ? 'checked' : '' }}>
                                    <label class="btn btn-outline-warning" for="star{{ $i }}">
                                        {{ str_repeat('★', $i) . str_repeat('☆', 5-$i) }}
                                    </label>
                                @endfor
                            </div>
                        </div>
                        <div class="mb-3">
                            <label for="comment" class="form-label">Votre avis</label>
                            <textarea id="comment" class="form-control" name="comment" rows="4" value="" >{{ old('comment', $review->review ?? '') }}</textarea>
                        </div>
                        <div class="d-flex justify-content-end gap-2">
                            <button class="btn-orange" type="submit" style="">Enregistrer</button>
                            <button class="btn btn-outline-secondary" type="button" onclick="window.location='{{ route('review.index') }}'">Annuler</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
