<?php

namespace App\Http\Controllers\Manager\CategoryController;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;

class EditCategoryController extends Controller
{
    public function __invoke(Category $category)
    {
        return view('dashboard.category.edit', compact('category'));
    }
}
