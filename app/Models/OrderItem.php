<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrderItem extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function order(){
        return $this->belongsTo(Order::class);
    }

    public function product(){
        return $this->belongsTo(Product::class);
    }

    public function Ukuran()
    {
        return $this->belongsTo(Ukuran::class, 'ukuran_id');
    }

    public function toping()
    {
        return $this->belongsTo(Toping::class, 'toping_id');
    }
}
