<?php

namespace App\Http\Controllers\Client\ReviewController;

use App\Http\Controllers\Controller;
use App\Models\Review;
use Illuminate\Http\Request;

class EditReviewClientController extends Controller
{
    public function __invoke($reviewId, Request $request)
    {
        $review = Review::findOrFail($reviewId);

        return view('client.review.editReview', compact('review'));
    }
}
