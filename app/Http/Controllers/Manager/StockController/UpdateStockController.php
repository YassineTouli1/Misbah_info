<?php

namespace App\Http\Controllers\Manager\StockController;


use App\Http\Controllers\Controller;
use App\Models\Ingredient;
use App\Models\Stock;
use Illuminate\Http\Request;

class UpdateStockController extends Controller
{
    public function __invoke(Request $request, $id)
    {
        $validated = $request->validate([
            'name' => 'required',
            'quantite' => 'required',
            'price' => 'required',
            'fournisseur' => 'required',
            'image' => 'nullable|image|mimes:jpg,jpeg,png,gif|max:2048',
        ]);

        $ingredient = Ingredient::findOrFail($id);

        if ($request->hasFile('image')) {
            $path = $request->file('image')->store('ingredients', 'public');
            $validated['image'] = $path;
        }

        $ingredient->update($validated);

        return redirect()->route('stock.index')->with('success', 'Ingrédient mis à jour avec succès.');
    }
}





