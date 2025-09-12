<?php

namespace App\Http\Controllers\Manager\StockController;


use App\Http\Controllers\Controller;
use App\Models\Ingredient;
use App\Models\Stock;
use Illuminate\Http\Request;

class AddStockController extends Controller
{
    public function __invoke()
    {
        return view('dashboard.ingredient.addingredient');
    }
}





