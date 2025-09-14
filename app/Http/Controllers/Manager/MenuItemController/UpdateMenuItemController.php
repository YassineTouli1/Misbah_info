<?php

namespace App\Http\Controllers\Manager\MenuItemController;

use App\Http\Controllers\Controller;
use App\Models\Ingredient;
use App\Models\MenuItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class UpdateMenuItemController extends Controller
{

    public function __invoke(MenuItem $menuItem, Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'price' => 'required|numeric|min:0',
            'ingredients' => 'sometimes|array',
            'category_id' => 'required|exists:categories,id',
            'ingredients.*' => 'exists:ingredients,id',
            'image' => 'nullable|image|mimes:jpg,jpeg,png,gif,webp|max:2048',
        ]);
        // Gestion de l'image
        if ($request->hasFile('image')) {
            if ($menuItem->image && Storage::disk('public')->exists($menuItem->image)) {
                Storage::disk('public')->delete($menuItem->image);
            }
            $path = $request->file('image')->store('menu_items', 'public');
            $validated['image'] = $path;
        } else {
            $validated['image'] = $menuItem->image;
        }
        $menuItem->update($validated);
        // Synchronisation simple des ingrédients (sans données pivot)
        if ($request->has('ingredients')) {
            $menuItem->ingredients()->sync($validated['ingredients']);
        }
        return redirect()->route('menuItems')
            ->with('success', 'Plat mis à jour avec succès.');
    }

}
