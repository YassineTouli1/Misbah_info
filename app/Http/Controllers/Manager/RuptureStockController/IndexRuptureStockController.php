<?php

namespace App\Http\Controllers\Manager\RuptureStockController;

use App\Http\Controllers\Controller;
use App\Models\Ingredient;
class IndexRuptureStockController extends Controller
{
    public function __invoke()
    {
        $ingredients = Ingredient::where('quantite', '<=', 0)->get();
        return view('dashboard.stock.rupture',compact('ingredients'));
    }

}
