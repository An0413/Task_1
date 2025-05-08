<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreOrderRequest;
use App\Http\Requests\UpdateOrderRequest;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use App\Models\Stock;
use App\Models\StockMovement;
use App\Models\Warehouse;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;

class OrderController extends Controller
{
    public function index()
    {
        $orders = Order::with(['items.product', 'warehouse'])->get();

        if (request('status')) {
            $orders->where('status', request('status'));
        }
        if (request('customer')) {
            $orders->where('customer', 'like', '%' . request('customer') . '%');
        }
        $products = Product::all();
        return view("orders.list", compact('orders', 'products'));
    }

    public function create()
    {
        $warehouses = Warehouse::all();
        $products = Product::all();
        return view("orders.create", compact('warehouses', 'products'));
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
                    ->first();

                if (!$stock || $stock->stock < $item['count']) {
                    return redirect()->back()->with('error', 'Недостаточно товара на складе.');
                }

                Stock::where('product_id', $item['product_id'])
                    ->where('warehouse_id', $data['warehouse_id'])
                    ->update([
                        'stock' => DB::raw("stock - {$item['count']}")
                    ]);


                OrderItem::create([
                    'order_id' => $order->id,
                    'product_id' => $item['product_id'],
                    'count' => $item['count'],
                ]);

//                log stock movement
                StockMovement::create([
                    'product_id' => $item['product_id'],
                    'warehouse_id' => $data['warehouse_id'],
                    'order_id' => $order->id,
                    'change' => -$item['count'],
                    'reason' => 'order_created',
                    'created_at' => now(),
                ]);
            }
            return redirect()->route('orders');
        });
    }

    public function edit(Order $order)
    {
        $warehouses = Warehouse::all();
        $products = Product::all();

        return view('orders.edit', compact('order', 'warehouses', 'products'));
    }

    public function update(UpdateOrderRequest $request, Order $order)
    {
        return DB::transaction(function () use ($request, $order) {
            $data = $request->validated();

            // Если изменился только customer, обновляем только его
            if (isset($data['customer']) && $data['customer'] !== $order->customer) {
                $order->customer = $data['customer'];
                $order->save();
            }

            // Сравниваем старые и новые позиции заказа
            $oldItems = $order->items->map(fn($i) => ['product_id' => $i->product_id, 'count' => $i->count])->toArray();
            $newItems = collect($data['items'])->map(fn($i) => ['product_id' => (int)$i['product_id'], 'count' => (int)$i['count']])->toArray();

            // Если список позиций изменился
            if ($oldItems !== $newItems) {
                foreach ($data['items'] as $item) {
                    $stock = Stock::where('product_id', $item['product_id'])
                        ->where('warehouse_id', $order->warehouse_id)
                        ->lockForUpdate()
                        ->first();

                    if (!$stock || $stock->stock < $item['count']) {
                        return redirect()->back()->with('error', 'Недостаточно товара на складе.');
                    }
                }

                // Возвращаем старые товары на склад
                foreach ($order->items as $item) {
                    $stock = Stock::where('product_id', $item->product_id)
                        ->where('warehouse_id', $order->warehouse_id)
                        ->lockForUpdate()
                        ->first();

                    if ($stock) {
                        DB::table('stocks')
                            ->where('product_id', $item->product_id)
                            ->where('warehouse_id', $order->warehouse_id)
                            ->update([
                                'stock' => DB::raw("stock + {$item->count}")
                            ]);

                        // Создаем запись о движении (возврат товара на склад)
                        StockMovement::create([
                            'product_id' => $item->product_id,
                            'warehouse_id' => $order->warehouse_id,
                            'order_id' => $order->id,
                            'change' => $item->count,
                            'reason' => 'order_update_return',
                        ]);
                    }

                    // Удаляем старые позиции
                    $item->delete();
                }

                // Обновляем складские остатки и создаем новые позиции
                foreach ($data['items'] as $item) {
                    $stock = Stock::where('product_id', $item['product_id'])
                        ->where('warehouse_id', $order->warehouse_id)
                        ->lockForUpdate()
                        ->first();

                    if (!$stock || $stock->stock < $item['count']) {
                        return redirect()->back()->with('error', 'Недостаточно товара на складе.');
                    }

                    // Обновляем остатки на складе
                    DB::table('stocks')
                        ->where('product_id', $item['product_id'])
                        ->where('warehouse_id', $order->warehouse_id)
                        ->update([
                            'stock' => DB::raw("stock - {$item['count']}")
                        ]);

                    // Создаем новое движение (убыток товара со склада)
                    StockMovement::create([
                        'product_id' => $item['product_id'],
                        'warehouse_id' => $order->warehouse_id,
                        'order_id' => $order->id,
                        'change' => -$item['count'],
                        'reason' => 'order_update_sale',
                    ]);

                    // Создаем новые позиции
                    OrderItem::create([
                        'order_id' => $order->id,
                        'product_id' => $item['product_id'],
                        'count' => $item['count'],
                    ]);
                }
            }

            return redirect()->route('orders')->with('success', 'Заказ успешно обновлен.');
        });
    }

    public function complete(Order $order)
    {
        if ($order->status !== 'active') {
            return redirect()->back()->with('error', 'Завершать можно только активные заказы.');
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
            Stock::where('product_id', $item->product_id)
                ->where('warehouse_id', $order->warehouse_id)
                ->update([
                    'stock' => DB::raw("stock + {$item->count}")
                ]);

            // Логируем возврат в StockMovement
            StockMovement::create([
                'product_id' => $item->product_id,
                'warehouse_id' => $order->warehouse_id,
                'order_id' => $order->id,
                'change' => $item->count,
                'reason' => 'order_canceled',
            ]);
        }

        $order->status = 'canceled';
        $order->save();

        return response()->json(['message' => 'Order canceled.']);
    }

    public function resume(Order $order)
    {
        if ($order->status !== 'canceled') {
            return redirect()->back()->with('error', 'Восстановить можно только отменённые заказы.');
        }

        foreach ($order->items as $item) {
            $stock = Stock::where('product_id', $item->product_id)
                ->where('warehouse_id', $order->warehouse_id)
                ->lockForUpdate()
                ->first();

            if (!$stock || $stock->stock < $item->count) {
                return redirect()->back()->with('error', 'Недостаточно товара на складе для восстановления заказа.');
            }

            // Уменьшаем остаток через raw
            Stock::where('product_id', $item->product_id)
                ->where('warehouse_id', $order->warehouse_id)
                ->update([
                    'stock' => DB::raw("stock - {$item->count}")
                ]);

            // Добавляем запись о движении
            StockMovement::create([
                'product_id' => $item->product_id,
                'warehouse_id' => $order->warehouse_id,
                'order_id' => $order->id,
                'change' => -$item->count,
                'reason' => 'order_resumed',
            ]);
        }

        $order->status = 'active';
        $order->save();
        return redirect()->route('orders')->with('success', 'Заказ успешно восстановлен.');
    }

}
