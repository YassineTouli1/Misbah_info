<?php

namespace App\Http\Controllers\Manager\CategoryController;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;

class StoreCategoryController extends Controller
{
    public function __invoke(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255|unique:categories,name',
        ]);

        Category::create($validated);

        return Redirect::route('category.index')->with('success', 'Catégorie créée avec succès!');
    }
}
