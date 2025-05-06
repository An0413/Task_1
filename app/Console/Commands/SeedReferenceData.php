<?php

namespace App\Console\Commands;

use App\Models\OrderItem;
use App\Models\Order;
use Illuminate\Console\Command;
use App\Models\Product;
use App\Models\Warehouse;
use App\Models\Stock;
use Illuminate\Support\Facades\DB;

class SeedReferenceData extends Command
{
    protected $signature = 'seed:references';
    protected $description = 'Наполняет справочники товаров, складов и остатков тестовыми данными';

    public function handle(): int
    {
        // Отключаем ограничения внешних ключей
        DB::statement('SET FOREIGN_KEY_CHECKS=0');

        // Очищаем старые данные
        $this->info('Очищаем старые данные...');
        Stock::truncate();
        OrderItem::truncate();
        Order::truncate();
        Product::truncate();
        Warehouse::truncate();

        // Включаем ограничения внешних ключей
        DB::statement('SET FOREIGN_KEY_CHECKS=1');

        $this->info('Создаём склады...');
        Warehouse::insert([
            ['name' => 'Склад №1'],
            ['name' => 'Склад №2'],
        ]);

        $this->info('Создаём товары...');
        Product::insert([
            ['name' => 'Ноутбук', 'price' => 1500],
            ['name' => 'Монитор', 'price' => 400],
            ['name' => 'Клавиатура', 'price' => 50],
            ['name' => 'Мышь', 'price' => 30],
        ]);

        $this->info('Создаём остатки товаров на складах...');
        $productIds = Product::pluck('id');
        $warehouseIds = Warehouse::pluck('id');

        foreach ($productIds as $productId) {
            foreach ($warehouseIds as $warehouseId) {
                Stock::create([
                    'product_id' => $productId,
                    'warehouse_id' => $warehouseId,
                    'stock' => rand(10, 100),
                ]);
            }
        }

        $this->info('Тестовые данные успешно добавлены.');

        return self::SUCCESS;
    }

}
