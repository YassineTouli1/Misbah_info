<?php

namespace App\Http\Controllers\Manager\MenuController;

use App\Http\Controllers\Controller;
use App\Models\Menu;

class DeleteMenuController extends Controller
{

    public function __invoke(Menu $menu)
    {
        $menu->delete();
        return redirect()->route('menus');
    }
}
