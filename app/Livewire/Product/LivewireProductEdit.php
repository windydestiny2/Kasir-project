<?php

namespace App\Livewire\Product;

use App\Models\Product;
use Illuminate\Support\Facades\Storage;
use Livewire\Component;
use Livewire\Features\SupportFileUploads\WithFileUploads;

class LivewireProductEdit extends Component
{
    use WithFileUploads;

    public $product_id;
    public $nm_produk;
    public $harga;
    public $kd_produk;
    public $stok;
    public $image;
    public $old_image;

    public function mount($products){
        $this->product_id = $products->id;
        $this->nm_produk = $products->nm_produk;
        $this->kd_produk = $products->kd_produk;
        $this->harga = number_format($products->harga, 0, ',', '.');
        $this->stok = $products->stok;
        $this->old_image = $products->image;
    }

    public function render()
    {
        return view('livewire.product.livewire-product-edit');
    }

    public function EditProduct(){
        $this->validate([
            'nm_produk' => ['required', 'string', 'max:255'],
            'stok' => ['required', 'integer', 'min:0'],
            'image' => ['nullable','image', 'mimes:jpg,png', 'max:1024']
        ]);

        $product = Product::findOrFail($this->product_id);

        if ($this->image) {
            $save_img = $this->image->store('product-image', 'public');

            if ($product->image) {
                Storage::disk('public')->delete($product->image);
            }
            $product->image = $save_img;
        }

        $harga = (int) str_replace('.', '', $this->harga);
        $product->update([
            'nm_produk' => $this->nm_produk,
            'harga' => $harga,
            'stok' => $this->stok,
            'image' => $product->image ?? $this->old_image,
        ]);

        $notif = array(
            'message' => 'Berhasil Diupdate',
            'alert-type' => 'success'
        );

        return redirect()->route('view.product')->with($notif);

        // $this->dispatch('info', message: 'Produk Berhasil Diubah');
        // $this->dispatch('editListener');
    }
}
