<?php

namespace App\Http\Controllers\Manager\StockController;


use App\Http\Controllers\Controller;
use App\Models\Ingredient;
use App\Models\Stock;
use Illuminate\Http\Request;

class DeleteStockController extends Controller
{
    public function __invoke($id)
    {
        Ingredient::findOrFail($id)->delete();
        return redirect()->back()->with('success', 'Ingrédient supprimé avec succès.');
    }
}





