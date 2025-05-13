<?php

namespace App\Livewire\Ukuran;

use App\Models\Product;
use App\Models\toping;
use App\Models\ukuran;
use Livewire\Component;

class TambahUkuran extends Component
{
    public $product = [];     // Semua produk
    public $topings = [];     // Topings yang berubah tergantung produk

    // dari blade
    public $myProduct = null; // ID Produk yang dipilih
    public $myToping = null;

    public $nama, $harga;

    

    public function mount()
    {
        $this->product = Product::all();
    }

    public function updatedMyProduct($value)
    {
        $this->topings = toping::where('id_product', $value)->get();
        $this->myToping = null; // reset toping jika produk berubah
    }

    public function TambahUkuran()
    {
        $this->validate([
            'myProduct' => 'required',
            'myToping' => 'required',
            'nama' => 'required',
            'harga' => 'required|numeric',
        ]);

        Ukuran::create([
            'id_product' => $this->myProduct,
            'id_toping' => $this->myToping,
            'nama' => $this->nama,
            'harga' => $this->harga,
        ]);

        $this->reset(['myProduct', 'myToping', 'nama', 'harga', 'topings']);

        $this->dispatch('success', message: 'Ukuran Berhasil Ditambah');
        $this->dispatch('UkuranTambah');

    }

    
    public function render()
    {   
        return view('livewire.ukuran.tambah-ukuran');
    }
}
