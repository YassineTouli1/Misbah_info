<?php

namespace App\Http\Controllers\Manager\MenuItemController;


use App\Http\Controllers\Controller;
use App\Models\MenuItem;
use App\Models\Ingredient;
use Illuminate\Http\Request;

class StoreMenuItemController extends Controller
{
    public function __invoke(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'price' => 'required|numeric',
            'category_id' => 'required|exists:categories,id',
            'ingredients' => 'required|array',
            'ingredients.*.id' => 'required|exists:ingredients,id',
            'ingredients.*.quantite' => 'required|numeric|min:0.01',
            'image' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);


        if ($request->hasFile('image')) {
            // Store in storage/app/public/menu_items/filename.extension
            $imagePath = $request->file('image')->store('menu_items', 'public');

            $menuItem = MenuItem::create([
                'name' => $validated['name'],
                'price' => $validated['price'],
                'category_id' => $validated['category_id'],
                'image' => $imagePath,
            ]);

            foreach ($request->ingredients as $ingredient) {
                $menuItem->ingredients()->attach($ingredient['id'], [
                    'quantity' => $ingredient['quantite']
                ]);

                $ingredientModel = Ingredient::find($ingredient['id']);
                $ingredientModel->quantite -= $ingredient['quantite'];
                $ingredientModel->save();
            }

            return redirect()->route('menuItems')->with('success', 'Plat ajouté avec succès.');
        }

        return back()->with('error', 'Échec de l\'upload de l\'image');
    }
}
