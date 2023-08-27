<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'description', 'price', 'menu_id'];

    public function menu() {
        return $this->belongsTo(Menu::class);
    }

    public function ingredients() {
        return $this->belongsToMany(Ingredient::class,  'product_ingredient');
    }

    public function orders() {
        return $this->belongsToMany(Order::class, 'order_product')->withPivot('quantity');
    }
}
