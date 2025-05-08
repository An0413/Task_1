<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrderItem extends Model
{
    use HasFactory;

    protected $fillable = [
        'order_id',
        'product_id',
        'count',
    ];
    // Отключаем использование временных меток
    public $timestamps = false;

    public function order()
    {
        return $this->belongsTo(Order::class);
    }

    // Принадлежит одному продукту
    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}
