<?php

namespace App\Livewire\Toping;

use App\Models\Product;
use App\Models\toping;
use Livewire\Component;
use Livewire\WithPagination;

class TableToping extends Component
{
    public $search = '';
    use WithPagination;
    protected $paginationTheme = 'bootstrap';
    

    protected $listeners = ['topingTambah', 'TopingHapus' => 'render'];

    public function render()
    {
        $topings = toping::with('product')
        ->where('name_toping', 'like', '%' .$this->search.'%' )
        ->paginate(10);
        return view('livewire.toping.table-toping', compact('topings'));
    }

    public function DeleteToping($id){
        $toping = toping::findOrFail($id);

        $toping->delete();
        
        $this->dispatch('success', message: 'Berhasil Dihapus');
        $this->dispatch('TopingHapus');
    }
}
