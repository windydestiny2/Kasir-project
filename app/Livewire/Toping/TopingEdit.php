<?php

namespace App\Livewire\Toping;

use App\Models\Product;
use App\Models\toping;
use Livewire\Component;

class TopingEdit extends Component
{

    public $product;
    public $id_product;
    public $id_toping;
    public $name_toping;

    public function mount($topings){
        $this->product = Product::all();
        $this->id_product = $topings->id_product;
        $this->id_toping = $topings->id;
        $this->name_toping = $topings->name_toping;
    }

    public function EditToping(){
        $this->validate([
            'id_product' => 'required|exists:products,id',
            'name_toping' => 'required|string|max:255',
        ]);

        $toping = toping::findOrFail($this->id_toping);

        $toping->update([
            'id_product' => $this->id_product,
            'name_toping' => $this->name_toping,
        ]);

        $notif = array(
            'message' => 'Berhasil Diupdate',
            'alert-type' => 'success'
        );

        return redirect()->route('view.toping')->with($notif);
    }

    public function render()
    {
        return view('livewire.toping.toping-edit');
    }
}
