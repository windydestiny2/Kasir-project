<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cart extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function product(){
        return $this->belongsTo(Product::class, 'id_product', 'id');
    }

    public function Ukuran()
    {
        return $this->belongsTo(Ukuran::class, 'Ukuran_id');
    }
}
