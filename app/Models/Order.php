<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    protected $fillable = ['customer_name', 'total_amount'];

    public function items() {
        return $this->hasMany(OrderItem::class);
    }

    public function products() {
        return $this->belongsToMany(Product::class, 'order_product')->withPivot('quantity');
    }
}
