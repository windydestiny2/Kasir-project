<?php

namespace App\Livewire\Kategori;

use App\Models\Kategori;
use Livewire\Component;

class TambahKategori extends Component
{   
    // ambil inputan
    public $kategori;

    public function TambahKategori(){

        // validasi diambil dari wiremodel
        $this->validate([
            'kategori' => 'required|unique:kategoris,categori'
        ]);

        // simpan dalam database
        Kategori::insert([
            'categori' => $this->kategori
        ]);

        // reset isi inputan jika sudah disubmit
        // diambil dari wire model
        $this->reset([
            'kategori'
        ]);

        // listener
        $this->dispatch('success', message: 'Kategori Berhasil Ditambahkan');
        $this->dispatch('addKategori');
    }

    

    public function render()
    {
        return view('livewire.kategori.tambah-kategori');
    }
}
