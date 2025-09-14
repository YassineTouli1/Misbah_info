<?php

namespace App\Http\Controllers\Manager\CategoryController;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;

class IndexCategoryController extends Controller
{
    public function __invoke(Request $request)
    {
        $categories = Category::all();
        dd($categories->getTable());
        return view('dashboard.category.index', compact('categories'));
    }
}
