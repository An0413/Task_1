<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreOrderRequest;
use App\Http\Requests\UpdateOrderRequest;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Stock;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;

class OrderController extends Controller
{
    public function index(): JsonResponse
    {
        $query = Order::with(['items.product', 'warehouse']);

        if (request('status')) {
            $query->where('status', request('status'));
        }
        if (request('customer')) {
            $query->where('customer', 'like', '%' . request('customer') . '%');
        }

        $orders = $query->paginate(request('per_page', 10));
        return response()->json($orders);
    }

    public function store(StoreOrderRequest $request): JsonResponse
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
                    ->where('warehouse_id', $data['warehouse_id'])->lockForUpdate()->first();

                if (!$stock || $stock->stock < $item['count']) {
                    return response()->json(['error' => 'Ապրանքների քանակը բավարար չէ'], 400);
                }

                $stock->decrement('stock', $item['count']);

                OrderItem::create([
                    'order_id' => $order->id,
                    'product_id' => $item['product_id'],
                    'count' => $item['count'],
                ]);
            }

            return response()->json($order, 201);
        });
    }

    public function update(UpdateOrderRequest $request, Order $order): JsonResponse
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

    public function complete(Order $order): JsonResponse
    {
        if ($order->status !== 'active') {
            return response()->json(['error' => 'Միայն ակտիվ պատվերները կարող են ավարտվել'], 400);
        }

        $order->status = 'completed';
        $order->completed_at = now();
        $order->save();

        return response()->json(['message' => 'Պատվերը հաջողությամբ ավարտվեց']);
    }

    public function cancel(Order $order): JsonResponse
    {
        if ($order->status !== 'active') {
            return response()->json(['error' => 'Միայն ակտիվ պատվերները կարող են չեղարկվել'], 400);
        }

        foreach ($order->items as $item) {
            $stock = Stock::where('product_id', $item->product_id)
                ->where('warehouse_id', $order->warehouse_id)->lockForUpdate()->first();

            $stock->increment('stock', $item->count);
        }

        $order->status = 'canceled';
        $order->save();

        return response()->json(['message' => 'Պատվերը չեղարկված է']);
    }

    public function resume(Order $order): JsonResponse
    {
        if ($order->status !== 'canceled') {
            return response()->json(['error' => 'Միայն չեղարկված պատվերները կարող են վերականգնվել'], 400);
        }

        foreach ($order->items as $item) {
            $stock = Stock::where('product_id', $item->product_id)
                ->where('warehouse_id', $order->warehouse_id)->lockForUpdate()->first();

            if (!$stock || $stock->stock < $item->count) {
                return response()->json(['error' => 'Քանակը բավարար չէ ապրանքի վերականգնման համար'], 400);
            }

            $stock->decrement('stock', $item->count);
        }

        $order->status = 'active';
        $order->save();

        return response()->json(['message' => 'Պատվերը վերականգնվել է']);
    }
}
