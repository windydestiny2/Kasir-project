<?php

namespace App\Livewire\Ukuran;

use App\Models\ukuran;
use Livewire\Component;
use Livewire\WithPagination;

class Tableukuran extends Component
{
    public $search = '';
    use WithPagination;
    protected $paginationTheme = 'bootstrap';

    protected $listeners = ['UkuranTambah', 'UkuranHapus' => 'render'];

    public function render()
    {
        $ukurans = ukuran::with('toping')
        ->where('nama', 'like', '%' .$this->search.'%' )
        ->paginate(10);
        return view('livewire.ukuran.tableukuran', compact('ukurans'));
    }

    public function DeleteUkuran($id){
        $ukuran = ukuran::findOrFail($id);

        $ukuran->delete();
        
        $this->dispatch('success', message: 'Berhasil Dihapus');
        $this->dispatch('UkuranHapus');
    }
}
