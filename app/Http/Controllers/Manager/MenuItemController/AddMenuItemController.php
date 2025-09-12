<?php

namespace App\Http\Controllers\Manager\MenuItemController;

use App\Http\Controllers\Controller;
use App\Models\Ingredient;
use App\Models\Category;
use Illuminate\Http\Request;

class AddMenuItemController extends Controller
{

    public function __invoke(Request $request)
    {
        $ingredients = Ingredient::all();
        $categories = Category::all();
        return view('dashboard.menuItem.addMenuItem', compact('ingredients','categories'));
    }

}
