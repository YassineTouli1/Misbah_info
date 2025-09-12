<?php

namespace App\Http\Controllers\Client\MenusController;

use App\Http\Controllers\Controller;
use App\Models\Menu;
class IndexMenusController extends Controller
{

    public function __invoke()
    {
        $menus=Menu::where('available',1)->get();
        return view('client.menus.menus',compact('menus'));
    }
}
