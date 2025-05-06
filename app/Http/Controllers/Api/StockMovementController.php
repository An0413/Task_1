<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\StockMovement;

class StockMovementController extends Controller
{
    /**
     * Display a listing of the stock movements.
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     *
     * Filters:
     * - product_id
     * - warehouse_id
     * - date_from (format: Y-m-d)
     * - date_to (format: Y-m-d)
     * - per_page (int)
     */
    public function index(Request $request)
    {
        $query = StockMovement::query();

        if ($request->has('product_id')) {
            $query->where('product_id', $request->input('product_id'));
        }

        if ($request->has('warehouse_id')) {
            $query->where('warehouse_id', $request->input('warehouse_id'));
        }

        if ($request->has('date_from')) {
            $query->whereDate('created_at', '>=', $request->input('date_from'));
        }

        if ($request->has('date_to')) {
            $query->whereDate('created_at', '<=', $request->input('date_to'));
        }

        $perPage = $request->input('per_page', 15); // Default pagination size = 15

        $movements = $query->orderBy('created_at', 'desc')->paginate($perPage);

        return response()->json($movements);
    }
}
