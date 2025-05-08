<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;
    public $timestamps = false;
    protected $fillable = [
        'customer',
        'warehouse_id',
        'status',
//        'completed_at',
//        'canceled_at',
        // добавьте сюда все остальные поля, которые вы хотите заполнить, создайте/обновите
    ];
    public function items()
    {
        return $this->hasMany(OrderItem::class);
    }

    // Склад, с которого был выполнен заказ
    public function warehouse()
    {
        return $this->belongsTo(Warehouse::class);
    }
}
