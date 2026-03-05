<?php

namespace App\Livewire\Ukuran;

use App\Models\Product;
use App\Models\toping;
use App\Models\Ukuran;
use Livewire\Component;

class UkuranEdit extends Component
{
    public $product = [];
    public $topings = [];

    public $myProduct;
    public $myToping;

    public $nama, $harga;
    public $id_Ukuran;

    public function mount($Ukurans){
        $this->product = Product::all();
        $this->id_Ukuran = $Ukurans->id;
        $this->nama = $Ukurans->nama;
        $this->harga = $Ukurans->harga;
        $this->myToping = $Ukurans->id_toping;
        $this->myProduct = $Ukurans->id_product;

        $this->topings = toping::where('id_product', $Ukurans->id_product)->get();
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

        $Ukuran = Ukuran::findOrFail($this->id_Ukuran);

        $Ukuran->update([
            'id_product' => $this->myProduct,
            'id_toping' => $this->myToping,
            'nama' => $this->nama,
            'harga' => $this->harga,
        ]);

        $notif = array(
            'message' => 'Berhasil Diupdate',
            'alert-type' => 'success'
        );

        return redirect()->route('view.Ukuran')->with($notif);
    }



    public function render()
    {
        return view('livewire.Ukuran.Ukuran-edit');
    }
}
