<?php

namespace App\Http\Controllers\HomeController;

use App\Http\Controllers\Controller;
use App\Models\Review;
use App\Models\Setting;
use Illuminate\Support\Facades\Log;
use Throwable;

class HomeController extends Controller
{
    public function __invoke()
    {
        try {
            $reviews = Review::latest()->take(10)->get();
        } catch (Throwable $e) {
            // In case the database is not ready or table is missing, avoid 500 on homepage
            Log::warning('Home page reviews query failed: ' . $e->getMessage());
            $reviews = collect();
        }

        try {
            $settings = Setting::query()->first();
        } catch (Throwable $e) {
            Log::warning('Home page settings query failed: ' . $e->getMessage());
            $settings = null;
        }

        return view('home', compact('reviews', 'settings'));
    }
}
