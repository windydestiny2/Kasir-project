<?php

namespace App\Livewire\Ukuran;

use App\Models\Ukuran;
use Livewire\Component;
use Livewire\WithPagination;

class TableUkuran extends Component
{
    public $search = '';
    use WithPagination;
    protected $paginationTheme = 'bootstrap';

    protected $listeners = ['UkuranTambah', 'UkuranHapus' => 'render'];

    public function render()
    {
        $Ukurans = Ukuran::with('toping')
        ->where('nama', 'like', '%' .$this->search.'%' )
        ->paginate(10);
        return view('livewire.Ukuran.tableUkuran', compact('Ukurans'));
    }

    public function DeleteUkuran($id){
        $Ukuran = Ukuran::findOrFail($id);

        $Ukuran->delete();
        
        $this->dispatch('success', message: 'Berhasil Dihapus');
        $this->dispatch('UkuranHapus');
    }
}
