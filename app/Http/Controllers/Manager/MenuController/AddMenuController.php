<?php

namespace App\Http\Controllers\Manager\MenuController;

use App\Models\MenuItem;
use Illuminate\Http\Request;

class AddMenuController
{
    public function __invoke(Request $request)
    {
        $menuItems=MenuItem::all();
        return view('dashboard.menu.addMenu',compact('menuItems'));
    }

}
