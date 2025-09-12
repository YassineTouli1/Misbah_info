<?php

namespace App\Http\Controllers\Manager\CategoryController;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;

class UpdateCategoryController extends Controller
{
    public function __invoke(Request $request, Category $category)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255|unique:category,name,' . $category->id,
        ]);

        $category->update($validated);

        return Redirect::route('category.index')->with('success', 'Catégorie mise à jour avec succès!');
    }
}
