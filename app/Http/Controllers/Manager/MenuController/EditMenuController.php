<?php

namespace App\Http\Controllers\Manager\MenuController;

use App\Http\Controllers\Controller;
use App\Models\Menu;
use App\Models\MenuItem;

class EditMenuController extends Controller
{
    public function __invoke(Menu $menu)
    {
        $menuItems = MenuItem::all();
        return view('dashboard.menu.editMenu',compact('menu','menuItems'));
    }

}
