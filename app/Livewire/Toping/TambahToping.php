<?php

namespace App\Livewire\Toping;

use App\Models\Product;
use App\Models\toping;
use Livewire\Component;

class TambahToping extends Component
{

    public $name_toping;

    public $id_product;
    public $product;

    public function mount(){
        // ambil data kategori dr database
        $this->product = Product::all();
    }

    public function TambahToping(){
        $this->validate([
            'name_toping' => ['required', 'string', 'max:255'],
            'id_product' => ['required', 'exists:products,id'],
        ]);

        toping::insert([
            'name_toping' => $this->name_toping,
            'id_product' => $this->id_product,
        ]);
        

        $this->reset([
            'name_toping', 'id_product'
        ]);

        $this->dispatch('success', message: 'Toping Berhasil Ditambahkan');

        $this->dispatch('topingTambah');
    }

    public function render()
    {
        return view('livewire.toping.tambah-toping');
    }
}
