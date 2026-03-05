<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Ukuran extends Model
{
    protected $guarded = [];

    public function product(){
        return $this->belongsTo(Product::class, 'id_product', 'id');
    }

    public function toping(){
        return $this->belongsTo(toping::class, 'id_toping', 'id');
    }

    

    
}
