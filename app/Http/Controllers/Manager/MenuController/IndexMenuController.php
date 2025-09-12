<?php

namespace App\Http\Controllers\Manager\MenuController;


use App\Http\Controllers\Controller;
use App\Models\Menu;
use Illuminate\Http\Request;

class IndexMenuController extends Controller
{
    public function __invoke(Request $request)
    {
        $menus = Menu::with('menuItems')->get();
        return view('dashboard.menu.menu',compact('menus'));
    }
}





