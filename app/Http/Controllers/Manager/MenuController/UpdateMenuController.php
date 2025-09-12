<?php

namespace App\Http\Controllers\Manager\MenuController;

use App\Models\Menu;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class UpdateMenuController extends Controller
{
    public function __invoke(Menu $menu, Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'available' => 'nullable|boolean',
            'items' => 'sometimes|array',
            'items.*' => 'exists:menu_items,id',
        ]);
        $menu->update([
            'title' => $validated['title'],
            'available' => $request->has('available'),
        ]);

        // Synchronisation simple des plat

        if (isset($validated['items'])) {
            $menu->menuItems()->sync($validated['items']);
        }

        return redirect()->route('menus')
            ->with('success', 'Menu mis à jour avec succès.');
    }

}
