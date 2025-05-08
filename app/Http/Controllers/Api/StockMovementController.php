<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request;
use App\Models\StockMovement;

class StockMovementController extends Controller
{
    public function index(Order $order)
    {
        $movements = StockMovement::where('warehouse_id', $order->warehouse_id)
            ->where('order_id', $order->id)
            ->whereIn('product_id', $order->items->pluck('product_id'))
            ->with('product')
            ->latest()
            ->get();

        return view('stock_movements.index', compact('order', 'movements'));
    }

}
