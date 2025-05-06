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
        // ավելացրու այստեղ բոլոր մյուս դաշտերը, որ ցանկանում ես լրացնել create/update-ով
    ];
    public function items()
    {
        return $this->hasMany(OrderItem::class);
    }

    // Պահեստը, որից պատվերը կատարվել է
    public function warehouse()
    {
        return $this->belongsTo(Warehouse::class);
    }
}
