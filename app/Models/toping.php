<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class toping extends Model
{
    protected $guarded = [];

    public function product(){
        return $this->belongsTo(Product::class, 'id_product', 'id');
    }

    public function ukuran(){
        return $this->hasMany(ukuran::class, 'id_toping', 'id');
    }
}
