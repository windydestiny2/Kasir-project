<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class toping extends Model
{
    protected $guarded = [];

    public function product(){
        return $this->belongsTo(Product::class, 'id_product', 'id');
    }

    public function Ukuran(){
        return $this->hasMany(Ukuran::class, 'id_toping', 'id');
    }
}
