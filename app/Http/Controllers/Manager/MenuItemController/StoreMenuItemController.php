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
            // Create directory if it doesn't exist
            $path = public_path('images/menu_items');
            if (!file_exists($path)) {
                mkdir($path, 0777, true);
            }
            
            // Store the file
            $imageName = time().'_'.$request->file('image')->getClientOriginalName();
            $request->file('image')->move($path, $imageName);
            $imagePath = 'images/menu_items/'.$imageName;

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
