<?php

namespace App\Http\Controllers\Manager\StockController;


use App\Http\Controllers\Controller;
use App\Models\Ingredient;
use App\Models\Stock;
use Illuminate\Http\Request;

class EditStockController extends Controller
{
    public function __invoke($id)
    {
        $ingredient = Ingredient::findOrFail($id);
        return view('dashboard.ingredient.editingredient', compact('ingredient'));
    }
}





