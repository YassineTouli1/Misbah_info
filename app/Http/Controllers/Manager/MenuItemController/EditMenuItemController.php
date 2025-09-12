<?php

namespace App\Http\Controllers\Manager\MenuItemController;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Ingredient;
use App\Models\MenuItem;
use Illuminate\Http\Request;

class EditMenuItemController extends Controller
{

    public function __invoke(MenuItem $menuItem)
    {
        $categories=Category::all();
        $ingredients = Ingredient::all();
        return view('dashboard.menuItem.editMenuItem', compact('menuItem', 'ingredients', 'categories'));
    }

}
