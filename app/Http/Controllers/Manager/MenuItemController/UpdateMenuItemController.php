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
            // Delete old image if it exists
            if ($menuItem->image && file_exists(public_path($menuItem->image))) {
                unlink(public_path($menuItem->image));
            }
            
            // Create directory if it doesn't exist
            $path = public_path('images/menu_items');
            if (!file_exists($path)) {
                mkdir($path, 0777, true);
            }
            
            // Store the new file
            $imageName = time().'_'.$request->file('image')->getClientOriginalName();
            $request->file('image')->move($path, $imageName);
            $validated['image'] = 'images/menu_items/'.$imageName;
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
