<?php

namespace App\Livewire\Order;

use App\Models\Cart;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use App\Models\toping;
use App\Models\ukuran;
use App\Models\User;
use GuzzleHttp\Handler\Proxy;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Livewire\WithPagination;

class OrderPesanan extends Component
{

    protected $listeners = ['hapusListener', 'scanListener', 'cartListener', 'stokUpdate' => 'render'];

    use WithPagination;
    protected $paginationTheme = 'bootstrap';

    public $search = '';

    public $totalBelanja = 0;
    public $totalBayar = '';
    public $kembalian = 0;
    public $catatan;

    public $qrCode; 

    
    // dari blade
    public $myToping;
    public $toping = [];      // toping[cart_id]
    public $ukuran = [];      // ukuran[cart_id]
    public $myUkuran = [];    // myUkuran[cart_id]
    public $hargaUkuran = []; // hargaUkuran[cart_id]

    // pilih toping sesuai id
    public function updatedToping($value, $key)
    {
        // $key adalah cart_id
        $cartId = $key;
        $this->myUkuran[$cartId] = \App\Models\Ukuran::where('id_toping', $value)->get();
        $this->ukuran[$cartId] = null;
        $this->hargaUkuran[$cartId] = 0;

        $cart = \App\Models\Cart::find($cartId);
        if ($cart) {
            $cart->price = 0;
            $cart->ukuran_id = null;
            $cart->save();
        }

        $this->hitungTotal();
    }

    // pilih ukuran sesuai id
    public function updatedUkuran($value, $cartId)
    {
        $ukuran = Ukuran::find($value);
        if ($ukuran) {
            $cart = Cart::find($cartId);
            if ($cart) {
                $cart->price = $ukuran->harga;
                $cart->ukuran_id = $ukuran->id;
                $cart->save();

                // Set harga untuk input tampilannya
                $this->hargaUkuran[$cartId] = $ukuran->harga;

                $this->hitungTotal();
            }
        }
    }

    
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

        $this->dispatch('success', message: 'Produk berhasil ditambahkan');
        $this->dispatch('scanListener');
    }

    public function updatingSearch(){
        $this->resetPage();
    }


    public function increment($cartId)
    {
        $cart = Cart::find($cartId);
        if ($cart && $cart->qty < $cart->product->stok) {
            $cart->increment('qty');

            // Ambil harga dari ukuran yang dipilih per cart ID
            $ukuranId = $this->ukuran[$cartId] ?? null;
            if ($ukuranId) {
                $ukuran = \App\Models\Ukuran::find($ukuranId);
                if ($ukuran) {
                    $cart->price = $ukuran->harga;
                }
            }

            $cart->save();
            $this->hitungTotal();
        }
    }

    public function decrement($cartId)
    {
        $cart = Cart::find($cartId);
        if ($cart && $cart->qty > 1) {
            $cart->decrement('qty');

            // Ambil harga dari ukuran yang dipilih per cart ID
            $ukuranId = $this->ukuran[$cartId] ?? null;
            if ($ukuranId) {
                $ukuran = \App\Models\Ukuran::find($ukuranId);
                if ($ukuran) {
                    $cart->price = $ukuran->harga;
                }
            }

            $cart->save();
            $this->hitungTotal();
        }
    }



    public function mount(){
        $this->hitungTotal();
        $this->hitungKembalian();
        // $this->products = Product::all();

        $carts = Cart::where('id_user', Auth::id())->get();

        foreach ($carts as $cart) {
            $this->toping[$cart->id] = null;
            $this->ukuran[$cart->id] = null;
            $this->myUkuran[$cart->id] = [];
            $this->hargaUkuran[$cart->id] = 0;
        }
    }



    public function hitungTotal()
    {
        $carts = Cart::where('id_user', Auth::id())->get();

        $this->totalBelanja = $carts->sum(function ($cart) {
            // Jika ukuran dipilih, gunakan harga ukuran
            if ($cart->ukuran) {
                return $cart->qty * $cart->ukuran->harga;
            }
            // Jika ukuran tidak dipilih, gunakan harga produk biasa
            return $cart->qty * $cart->price;
        });

        $this->hitungKembalian();
    }


    public function hitungKembalian()
    {
        // $this->totalBelanja();
        $totalBayar = (int) str_replace('.', '', $this->totalBayar);
        $this->kembalian = max(0, ((int) $totalBayar) - $this->totalBelanja);
    }



    public function updatedTotalBayar()
    {
        $this->hitungKembalian();
    }


    public function bayar()
    {
        $qtyCart = Cart::where('id_user', Auth::id())->sum('qty');

        $totalBayar = (int) str_replace('.', '', $this->totalBayar);

        if ($qtyCart == 0) {
            $this->dispatch('error', message: 'Masukan produk dalam order dulu');
            return;
        }

        if ($totalBayar < $this->totalBelanja) {
            $this->dispatch('error', message: 'Masukan Total Bayar Dengan Benar');
            return;
        }

        // Simpan order
        $order = Order::create([
            'user_id' => Auth::id(),
            'total' => $this->totalBelanja,
            'total_bayar' => $totalBayar,
            'kembalian' => $this->kembalian,
            'status' => $this->catatan,
        ]);

        $carts = Cart::with(['product', 'ukuran'])->where('id_user', Auth::id())->get();

        foreach ($carts as $cart) {
            $product = $cart->product;

            if ($product && $product->stok >= $cart->qty) {
                $product->decrement('stok', $cart->qty);

                OrderItem::create([
                    'order_id' => $order->id,
                    'product_id' => $cart->id_product,
                    'qty' => $cart->qty,
                    'price' => $cart->price,
                    'total' => $cart->qty * $cart->price,
                    'ukuran_id' => $cart->ukuran_id, // dari cart
                    'toping_id' => optional($cart->ukuran)->id_toping, // ambil dari relasi ukuran
                ]);

                $cart->delete();
            }
        }

        $this->dispatch('success', message: 'Pesanan Berhasil dilakukan');
        $this->dispatch('stokUpdate');
        $this->reset(['totalBayar', 'catatan']);
    }


    public function DeletePesanan($id)
    {
        $cart = Cart::find($id);
        $cart->delete();

        $this->dispatch('success', message: 'Berhasil dihapus dari keranjang');
        $this->dispatch('hapusListener');

        $this->reset(['totalBelanja']);

        
    }

    public function tambahPesanan($id){
        $product = Product::find($id);

        if ($product->stok <= 0) {
            $this->dispatch('error', message: 'Stok Produk Habis');
            return;
        }

        // cek produk jika sudah ditambah
        $cart = Cart::where('id_product', $product->id)->where('id_user', Auth::id())
                      ->first();
        
        // create database
        if ($cart) {
            if ($cart->qty >= $product->stok) {
                $this->dispatch('error', message: 'Stok Produk Tidak Cukup');
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

    
        $this->dispatch('success', message: 'Produk Berhasil Ditambahkan');
        
        // $this->dispatch('tambahPesanan', $id); 
    }

    
    public function render()
    {
        $carts = Cart::where('id_user', Auth::id())->latest()->get();
        foreach ($carts as $cart) {
            if ($cart->product->stok <= 0) {
                $cart->delete();
            }
        }

        $this->hitungTotal();

        // $toping = toping::with('ukuran')->get();
        if ($this->myToping) {
            // dd($this->toping);
            $dataukuran = toping::where('id', $this->myToping)->first();
        }else{
            $dataukuran = NULL;
        }

        $products = Product::where('nm_produk', 'like', '%'.$this->search.'%')->paginate(10);
        return view('livewire.order.order-pesanan', compact('products'), [
            'carts' => Cart::with('product.toping')
                ->where('id_user', Auth::id())
                ->latest()
                ->get(),
                'dataukuran' => $dataukuran,
        ]);
    }
}
