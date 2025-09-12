<?php

namespace App\Http\Controllers\Manager\MenuController;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Menu;

class StoreMenuController
{

    public function __invoke(Request $request){

            $validated = $request->validate([
                'title' => 'required|string|max:255',
                'items' => 'array',
                'items.*' => 'exists:menu_items,id',
            ]);

            $menu = Menu::create([
                'title' => $validated['title'],
                'available' => true,
            ]);

            if (!empty($validated['items'])) {
                $menu->menuItems()->attach($validated['items']);
            }

            return redirect()->route('menus')->with('success', 'Menu ajouté avec succès.');

    }


}
