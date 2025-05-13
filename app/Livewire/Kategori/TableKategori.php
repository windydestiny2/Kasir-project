<?php

namespace App\Livewire\Kategori;

use App\Models\Kategori;
use Livewire\Component;
use Livewire\Features\SupportPagination\WithoutUrlPagination;
use Livewire\WithPagination;

class TableKategori extends Component
{   
    use WithPagination, WithoutUrlPagination;
    public $search = '';
    protected $paginationTheme = 'bootstrap';


    protected $listeners = ['addKategori', 'deleteKategori' => 'render'];

    public function search()
    {
        $this->resetPage();
    }

    public function render()
    {
        // $categories = Kategori::where('categori', 'like', '%'.$this->search.'%')->paginate(5);
        // return view('livewire.kategori.table-kategori', compact('categories'));
        return view('livewire.kategori.table-kategori', [
            'categories' => Kategori::where('categori', 'like', '%'.$this->search.'%')->paginate(5)
        ]);

    }

    public function DeleteKategori($id){
        $kategori = Kategori::findOrFail($id);

        $kategori->delete();

        $this->dispatch('success', message: 'Kategori Berhasil dihapus');
        $this->dispatch('deleteKategori');
    }
}
