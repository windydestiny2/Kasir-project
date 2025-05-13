<?php

namespace App\Livewire\Ukuran;

use App\Models\Product;
use App\Models\toping;
use App\Models\ukuran;
use Livewire\Component;

class UkuranEdit extends Component
{
    public $product = [];
    public $topings = [];

    public $myProduct;
    public $myToping;

    public $nama, $harga;
    public $id_ukuran;

    public function mount($ukurans){
        $this->product = Product::all();
        $this->id_ukuran = $ukurans->id;
        $this->nama = $ukurans->nama;
        $this->harga = $ukurans->harga;
        $this->myToping = $ukurans->id_toping;
        $this->myProduct = $ukurans->id_product;

        $this->topings = toping::where('id_product', $ukurans->id_product)->get();
    }

    public function updatedMyProduct($value)
    {
        $this->topings = toping::where('id_product', $value)->get();
        $this->myToping = null;
    }

    public function EditUkuran(){
        $this->validate([
            'myProduct' => 'required',
            'myToping' => 'required',
            'nama' => 'required',
            'harga' => 'required|numeric',
        ]);

        $ukuran = ukuran::findOrFail($this->id_ukuran);

        $ukuran->update([
            'id_product' => $this->myProduct,
            'id_toping' => $this->myToping,
            'nama' => $this->nama,
            'harga' => $this->harga,
        ]);

        $notif = array(
            'message' => 'Berhasil Diupdate',
            'alert-type' => 'success'
        );

        return redirect()->route('view.ukuran')->with($notif);
    }



    public function render()
    {
        return view('livewire.ukuran.ukuran-edit');
    }
}
