<?php

namespace App\Livewire\Order;

use App\Models\Cart;
use App\Models\Order;
use App\Models\Product;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class TambahOrder extends Component
{
    
    // protected $listeners = ['ordertListener' => 'render'];
    public $id_product;

    // public function TambahOrder()
    // {
    //     // ambil id produk
    //     $product = Product::findOrFail($this->id_product);

    //     // Cek apakah stok produk kosong
    //     if ($product->stok <= 0) {
    //         $this->dispatch('error', message: 'Stok Produk Habis');
    //         return;
    //     }

    //     // cek produk jika sudah ditambah
    //     $cart = Cart::where('id_product', $product->id)->where('id_user', Auth::id())
    //                   ->first();
        
    //     // create database
    //     if ($cart) {
    //         if ($cart->qty >= $product->stok) {
    //             $this->dispatch('error', message: 'Stok Produk Tidak Cukup');
    //             return;
    //         }
    //         $cart->qty += 1;
    //         $cart->save();
    //     } else {
    //         Cart::create([
    //             'id_product' => $product->id,
    //             'id_user' => Auth::id(),
    //             'qty' => 1,
    //             'price' => $product->harga,
    //         ]);
    //     }

    //     // session()->flash('success', 'Berhasil');
    //     $this->dispatch('success', message: 'Berhasil Tambah');

        
    //     $this->dispatch('cartListener'); 
        

    //     // return redirect()->to('/order');
    // }

    

    

    public function render()
    {
        return view('livewire.order.tambah-order');
    }
}
