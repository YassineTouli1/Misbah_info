<?php

namespace App\Http\Controllers\Client\ReviewController;

use App\Http\Controllers\Controller;
use App\Models\Review;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class IndexReviewClientController extends Controller
{
    public function __invoke(Request $request)
    {
        $reviews = Review::where('user_id', Auth::id())
            ->orderBy('created_at', 'desc')
            ->get();
        return view('client.review.IndexReview', compact('reviews'));
    }
}
