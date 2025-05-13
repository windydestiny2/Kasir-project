<?php

namespace App\Livewire\Product;

use App\Models\Product;
use Illuminate\Support\Facades\Storage;
use Livewire\Component;
use Livewire\WithPagination;

class LiviwireProductTable extends Component
{
    protected $listeners = ['productListener', 'hapusListener' => 'render'];

    public $search = '';
    use WithPagination;
    protected $paginationTheme = 'bootstrap';

    public function render()
    {
        $products = Product::with('kategori')
        ->where('nm_produk', 'like', '%' .$this->search.'%' )
        ->paginate(10);
        return view('livewire.product.liviwire-product-table', compact('products'));
    }

    public function DeleteProduct($id){
        $product = Product::findOrFail($id);

        if ($product->image) {
            Storage::disk('public')->delete($product->image);
        }

        if ($product->barcode) {
            Storage::disk('public')->delete($product->barcode);
        }

        $product->delete();
        
        $this->dispatch('error', message: 'Berhasil Dihapus');
        $this->dispatch('hapusListener');
    }
}
