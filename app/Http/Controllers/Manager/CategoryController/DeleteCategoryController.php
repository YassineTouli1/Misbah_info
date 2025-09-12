<?php

namespace App\Http\Controllers\Manager\CategoryController;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;

class DeleteCategoryController extends Controller
{
    public function __invoke(Category $category)
    {
        // Vérifier si la catégorie est utilisée par des éléments de menu
        if ($category->menuItems()->count() > 0) {
            return Redirect::back()->with('error', 'Impossible de supprimer cette catégorie car elle est utilisée par un ou plusieurs éléments du menu.');
        }

        $category->delete();
        
        return Redirect::route('category.index')->with('success', 'Catégorie supprimée avec succès!');
    }
}
