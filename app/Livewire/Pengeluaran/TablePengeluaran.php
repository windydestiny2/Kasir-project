<?php

namespace App\Livewire\Pengeluaran;

use App\Models\Pengeluaran;
use Livewire\Component;
use Livewire\WithPagination;

class TablePengeluaran extends Component
{

    public $search = '';
    use WithPagination;
    protected $paginationTheme = 'bootstrap';

    protected $listeners = ['tambahPengeluaran', 'hapusPengeluaran' => 'render'];

    public function DeletePengeluaran($id){
        $pengeluaran = Pengeluaran::findOrFail($id);

        $pengeluaran->delete();

        $this->dispatch('success', message :'Pengeluaran berhasil dihapus');
        $this->dispatch('hapusPengeluaran');

    }

    
    public function render()
    {
        $pengeluaran = Pengeluaran::where('tanggal', 'like', '%'.$this->search.'%')->paginate(10);
        return view('livewire.pengeluaran.table-pengeluaran', compact('pengeluaran'));
    }
}
