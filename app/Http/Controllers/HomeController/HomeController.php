<?php

namespace App\Http\Controllers\HomeController;

use App\Http\Controllers\Controller;
use App\Models\Review;

class HomeController extends Controller
{
    public function __invoke()
    {
        $reviews = Review::latest()->take(10)->get();

        return view('home', compact('reviews'));
    }
}
