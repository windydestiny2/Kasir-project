<?php

namespace App\Livewire\Product;

use App\Models\Kategori;
use App\Models\Product;
use Illuminate\Support\Facades\Storage;
use Livewire\Component;
use Livewire\Features\SupportFileUploads\WithFileUploads;
// use Milon\Barcode\DNS1D;
use Milon\Barcode\Facades\DNS1DFacade as DNS1D;

class LivewireProductCreate extends Component
{
    public $nm_produk;
    public $kd_produk;
    public $harga;
    public $stok;
    public $image;

    public $kategori;
    public $id_kategori;

    use WithFileUploads;

    public function mount(){
        // ambil data kategori dr database
        $this->kategori = Kategori::all();
    }



    public function render()
    {
        return view('livewire.product.livewire-product-create');
    }

    public function TambahProduct(){
        $this->validate([
            'nm_produk' => ['required', 'string', 'max:255'],
            'id_kategori' => ['required', 'exists:kategoris,id'],
            'kd_produk' => ['required', 'string', 'unique:products,kd_produk'],
            'stok' => ['required', 'integer', 'min:0'],
            'image' => ['required', 'image', 'mimes:jpg,png', 'max:1024']
        ]);

        $image = $this->image ? $this->image->store('product-image', 'public') : null;

        // generate barcode 
        $barcodeData = DNS1D::getBarcodeHTML($this->kd_produk, 'C128', 2, 50, 'black', true);

        // konversi barcode ke gambar
        $barcodePatch = 'product-barcode/' . $this->kd_produk . '.jpg';
        $barcodeImage = DNS1D::getBarcodeJPG($this->kd_produk, 'C128', 2, 50, [0,0,0], true);
        $barcodeImageData = base64_decode($barcodeImage);

        Storage::disk('public')->put($barcodePatch, $barcodeImageData);

        // clear format id
        $harga = (int) str_replace('.', '', $this->harga);

        Product::insert([
            'nm_produk' => $this->nm_produk,
            'kd_produk' => $this->kd_produk,
            'categori_id' => $this->id_kategori,
            'harga' => $harga,    
            'stok' => $this->stok,
            'image' => $image,
            'barcode' => $barcodePatch,
        ]);
        

        $this->reset([
            'nm_produk', 'kd_produk', 'harga', 'stok', 'image', 'id_kategori'
        ]);


        // $this->dispatch('success')->self();
        $this->dispatch('success', message: 'Produk Berhasil Ditambahkan');

        $this->dispatch('productListener');
        
        
        
    }
}
