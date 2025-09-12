<?php

namespace App\Http\Controllers\Manager\StockController;


use App\Http\Controllers\Controller;
use App\Models\Ingredient;
use App\Models\Stock;
use Illuminate\Http\Request;

class StoreStockClient extends Controller
{
    public function __invoke(Request $request)
    {
        $validation=request()->validate([
            'name'=>'required',
            'quantite'=>'required',
            'price'=>'required',
            'fournisseur'=>'required',
            'image'=>'nullable|image|mimes:jpg,jpeg,png,gif|max:2048'
        ]);
        if ($request->hasFile('image')) {
            $path = $request->file('image')->store('ingredients', 'public'); // storage/app/public/ingredients
            $validation['image'] = $path;
        }

        Ingredient::create($validation);
        $Stocks=Stock::with('ingredient')->get();

        return redirect()->route('stock.index')->with('success,Ingrédient ajouté avec succès.');
    }
}





