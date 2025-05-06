<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreOrderRequest;
use App\Http\Requests\UpdateOrderRequest;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Stock;
use App\Models\Warehouse;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;

class OrderController extends Controller
{
    public function index()
    {
        $order = Order::with(['items.product', 'warehouse'])->get();

        if (request('status')) {
            $order->where('status', request('status'));
        }
        if (request('customer')) {
            $order->where('customer', 'like', '%' . request('customer') . '%');
        }

//        $orders = $query->paginate(request('per_page', 10));
        return view("orders.list", compact('order'));
    }

    public function create(){
        $warehouses = Warehouse::all();
        return view("orders.create", compact('warehouses'));
    }

    public function store(StoreOrderRequest $request)
    {
            return DB::transaction(function () use ($request) {
            $data = $request->validated();

            $order = Order::create([
                'customer' => $data['customer'],
                'warehouse_id' => $data['warehouse_id'],
                'status' => 'active',
            ]);
                foreach ($data['items'] as $item) {
                    $stock = Stock::where('product_id', $item['product_id'])
                        ->where('warehouse_id', $data['warehouse_id'])
                        ->lockForUpdate()
                        ->first();

                    if (!$stock || $stock->stock < $item['count']) {
                        throw new \Exception('Ապրանքների քանակը բավարար չէ');
                    }

                    $stock->decrement('stock', $item['count']);

                    OrderItem::create([
                        'order_id' => $order->id,
                        'product_id' => $item['product_id'],
                        'count' => $item['count'],
                    ]);
                }
            return view("orders.list", compact('order'));
        });
    }

    public function update(UpdateOrderRequest $request, Order $order)
    {
        if ($order->status !== 'active') {
            return response()->json(['error' => 'Թարմացումը թույլատրվում է միայն ակտիվ պատվերների համար'], 400);
        }

        return DB::transaction(function () use ($request, $order) {
            $data = $request->validated();

            if (isset($data['customer'])) {
                $order->customer = $data['customer'];
                $order->save();
            }

            if (isset($data['items'])) {
                foreach ($order->items as $item) {
                    $stock = Stock::where('product_id', $item->product_id)
                        ->where('warehouse_id', $order->warehouse_id)->lockForUpdate()->first();
                    $stock->increment('stock', $item->count);
                    $item->delete();
                }

                foreach ($data['items'] as $item) {
                    $stock = Stock::where('product_id', $item['product_id'])
                        ->where('warehouse_id', $order->warehouse_id)->lockForUpdate()->first();

                    if (!$stock || $stock->stock < $item['count']) {
                        return response()->json(['error' => 'Քանակը բավարար չէ'], 400);
                    }

                    $stock->decrement('stock', $item['count']);

                    OrderItem::create([
                        'order_id' => $order->id,
                        'product_id' => $item['product_id'],
                        'count' => $item['count'],
                    ]);
                }
            }

            return response()->json($order);
        });
    }

    public function complete(Order $order)
    {
        if ($order->status !== 'active') {
            return response()->json(['error' => 'Only active orders can be completed.'], 400);
        }

        $order->status = 'completed';
        $order->completed_at = now();
        $order->save();

        return response()->json(['message' => 'Order completed successfully.']);
    }

    public function cancel(Order $order)
    {
        if ($order->status !== 'active') {
            return response()->json(['error' => 'Only active orders can be canceled.'], 400);
        }

        foreach ($order->items as $item) {
            $stock = Stock::where('product_id', $item->product_id)
                ->where('warehouse_id', $order->warehouse_id)->lockForUpdate()->first();

            $stock->increment('stock', $item->count);
        }

        $order->status = 'canceled';
        $order->save();

        return response()->json(['message' => 'Order canceled.']);
    }

    public function resume(Order $order)
    {
        if ($order->status !== 'canceled') {
            return response()->json(['error' => 'Միայն չեղարկված պատվերները կարող են վերականգնվել'], 400);
        }

        foreach ($order->items as $item) {
            $stock = Stock::where('product_id', $item->product_id)
                ->where('warehouse_id', $order->warehouse_id)->lockForUpdate()->first();

            if (!$stock || $stock->stock < $item->count) {
                return response()->json(['error' => 'Insufficient quantity for the product'], 400);
            }

            $stock->decrement('stock', $item->count);
        }

        $order->status = 'active';
        $order->save();

        return response()->json(['message' => 'Order restored']);
    }
}
