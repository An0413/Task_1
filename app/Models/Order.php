<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;
    public $timestamps = false;
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
