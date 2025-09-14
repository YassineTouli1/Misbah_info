<?php

namespace App\Http\Controllers\Client\ReviewController;

use App\Http\Controllers\Controller;
use App\Models\Review;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UpdateReviewClientController extends Controller
{
    public function __invoke($reviewId, Request $request)
    {
        $review = Review::findOrFail($reviewId);
        // Only allow the owner to update their review
        if ($review->user_id !== Auth::id()) {
            abort(403, 'Vous n\'êtes pas autorisé à modifier cet avis.');
        }
        $validated = $request->validate([
            'rating' => 'required|integer|min:1|max:5',
            'comment' => 'required|string|max:1000',
            
        ]);
        $review->update([
            'rating' => $validated['rating'],
            'review' => $validated['comment'],
        ]);
        return redirect()->route('review.index')->with('success', 'Avis modifié avec succès.');
    }
}
