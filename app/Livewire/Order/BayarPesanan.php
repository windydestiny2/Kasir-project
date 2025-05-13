<?php

namespace App\Livewire\Order;

use App\Models\Cart;
use App\Models\Product;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class BayarPesanan extends Component
{
    // protected $listeners = ['stokUpdate' => 'render'];
    // public function bayar()
    // {
    //     $carts = Cart::where('id_user', Auth::id())->get(); // Ambil data cart user saat ini
    
    //     foreach ($carts as $cart) {
    //         $product = Product::find($cart->id_product); // Ambil produk dari cart
    
    //         if ($product && $product->stok >= $cart->qty) {
    //             $product->stok -= $cart->qty; // Kurangi stok produk
    //             $product->save();
    //         } else {
    //             $this->dispatch('stokHabis', [
    //                 'message' => 'Stok tidak mencukupi untuk',
    //             ]);
    //             return; // Hentikan proses jika stok kurang
    //         }

    //         $this->dispatch('stokUpdate');
    //         $this->dispatch('success', message: 'work');
    //     }
    
    //     // Hapus pesanan setelah pembayaran
    //     // $carts = Cart::where('id_user', Auth::id())->get();
    //     // foreach ($carts as $cart) {
    //     //     Cart::where('id_product', $cart['product']['id'])->where('id_user', Auth::id())->delete();
    //     //     // Tampilkan notifikasi pembayaran sukses
    //     // }
    //     // $this->dispatch('stokUpdate');
    //     // $this->dispatch('success', message: 'work');
        
    // }
    

    public function render()
    {
        return view('livewire.order.bayar-pesanan');
    }
}
