<?php

namespace App\Livewire\Kategori;

use App\Models\Kategori;
use Livewire\Component;

class UpdateKategori extends Component
{   
    // ambil id dan kategori wiremodel(blade)
    public $kategori_id, 
    $kategori;

    // mount kategori diambil dr controller
    public function mount($kategori){
        $this->kategori_id = $kategori->id;
        $this->kategori = $kategori->categori;
    }

    public function EditKategori(){
        $this->validate([
            'kategori' => 'required'
        ]);

        $updateKategori = Kategori::findOrFail($this->kategori_id);

        $updateKategori->update([
            'categori' => $this->kategori
        ]);

        $notif = array(
            'message' => 'Kategori Berhasil Diupdate',
            'alert-type' => 'success'
        );

        return redirect()->route('view.kategori')->with($notif);
    }



    public function render()
    {
        return view('livewire.kategori.update-kategori');
    }
}
