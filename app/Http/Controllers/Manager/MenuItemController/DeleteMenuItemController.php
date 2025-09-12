<?php

namespace App\Http\Controllers\Manager\MenuItemController;

use App\Http\Controllers\Controller;
use App\Models\Ingredient;
use App\Models\MenuItem;
use Illuminate\Http\Request;

class DeleteMenuItemController extends Controller
{

    public function __invoke(MenuItem $menuItem)
    {
        $menuItem->delete();
        return redirect()->route('menuItems')->with('success', 'Plat supprimé avec succès.');
    }

}
