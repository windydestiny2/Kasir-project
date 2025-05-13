<?php

namespace App\Livewire\Order;

use App\Models\Cart;
use App\Models\OrderItem;
use App\Models\Product;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class ScanePesanan extends Component
{   
    public $qrCode; 

    // Fungsi ini akan dijalankan ketika properti qrCode berubah
    public function updatedQrCode($value)
    {
        $product = Product::where('kd_produk', $value)->first();

        $cart = Cart::where('id_product', $product->id)->where('id_user', Auth::id())
                      ->first();

         if ($product->stok <= 0) {
             $this->dispatch('error', message: 'Stok Produk Habis');
             return;
            }

        if ($cart) {
            if ($cart->qty >= $product->stok) {
                $this->dispatch('error', message: 'Stok Produk Habis');
                return;
            }
            $cart->qty += 1;
            $cart->save();
        } else {
            Cart::create([
                'id_product' => $product->id,
                'id_user' => Auth::id(),
                'qty' => 1,
                'price' => $product->harga,
            ]);
        }

        $this->dispatch('scanListener');
    }

    // protected $listeners = ['stokUpdate' => 'render'];



    


    public function render()
    {
        $products = Product::all();
        return view('livewire.order.scane-pesanan', compact('products'));
    }

    
}
