<?php

namespace App\Http\Controllers\Client\ReviewController;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class AddReviewClientController extends Controller
{
    public function __invoke(Request $request)
    {
        return view('client.review.addReview');
    }
} 