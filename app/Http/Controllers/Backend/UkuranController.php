<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\toping;
use App\Models\ukuran;
use Illuminate\Http\Request;

class UkuranController extends Controller
{
    public function viewUkuran(){
        $product = Product::orderBy('nm_produk', 'asc')->get();
        $toping = toping::orderBy('name_toping', 'asc')->get();
        return view('Backend.ukuran.ukuran-main', ['title' => 'Ukuran'], compact('product', 'toping'));
    }

    public function editUkuran($id){
        $ukurans = ukuran::findOrFail($id);
        return view('Backend.ukuran.ukuran-main-edit', ['title' => 'Ukuran'], compact('ukurans'));
    }


}
