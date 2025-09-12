<?php

namespace App\Http\Controllers\Manager\StockController;


use App\Http\Controllers\Controller;
use App\Models\Stock;
use Illuminate\Http\Request;

class IndexStockController extends Controller
{
    public function __invoke(Request $request)
    {
        $Stocks=Stock::with('ingredient')->get();
        return view('dashboard.stock.Stock',compact('Stocks'));
    }
}





