<?php

namespace App\Http\Controllers\Manager\MenuItemController;


use App\Http\Controllers\Controller;
use App\Models\MenuItem;
use Illuminate\Http\Request;

class IndexMenuItemController extends Controller
{
    public function __invoke(Request $request)
    {
        $menuItems=MenuItem::all();
        return view('dashboard.menuItem.menuItems',compact('menuItems'));
    }
}
