<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function orders(){
        return $this->hasMany(Order::class, 'id_product', 'id');
    }

    public function carts(){
        return $this->hasMany(Cart::class, 'id_product', 'id');
    }

    public function orderItems(){
        return $this->hasMany(OrderItem::class);
    }

    public function kategori(){
        return $this->belongsTo(Kategori::class, 'categori_id');
    }

    public function toping(){
        return $this->hasMany(toping::class, 'id_product', 'id');
    }    
}
