<?php

namespace App\Http\Controllers\Client\ReviewController;

use App\Http\Controllers\Controller;
use App\Models\Review;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class StoreReviewClient extends Controller
{
    public function __invoke(Request $request)
    {
        // Debug: Dump the request data to see what's being sent
        // dd($request->all());

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'rating' => 'required|integer|min:1|max:5',
            'comment' => 'required|string|max:1000', // Changed from 'review' to 'comment' to match the form
        ]);

        // Create the review with the validated data
        $review = Review::create([
            'name' => $validated['name'],
            'rating' => $validated['rating'],
            'review' => $validated['comment'], // Map 'comment' to 'review' column
            'user_id' => Auth::id(),
        ]);

        // Redirect to the reviews page with success message
        return redirect()->route('client.review')->with('success', 'Merci pour votre avis !');
    }
}
