<?php

namespace App\Http\Controllers\Client\ReviewController;

use App\Http\Controllers\Controller;
use App\Models\Review;
use Illuminate\Http\Request;

class DeleteReviewClientController extends Controller
{
    public function __invoke($reviewId, Request $request)
    {
        $review = Review::findOrFail($reviewId);
        $review->delete();
        return redirect()->route('client.review.index')->with('success', 'Avis supprimé avec succès.');
    }
}
