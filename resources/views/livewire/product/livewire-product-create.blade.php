<div>
    <div class="row">
        <div class="col-md-12">
            <!-- general form elements -->
            <div class="card card-primary">
                <div class="card-header">
                    <h3 class="card-title">Tambah Produk</h3>
                </div>
                <!-- /.card-header -->
                <!-- form start -->
                
                
                <form wire:submit.prevent='TambahProduct'>
                    <div class="card-body">

                        <div class="row">
                            <div class="form-group col-md-6">
                                <label for="nm_produk">Nama Produk</label>
                                <input type="text" wire:model='nm_produk' class="form-control @error('nm_produk')
                                is-invalid
                                @enderror" id="nm_produk"
                                    placeholder="Masukan Nama Produk">
                                    @error('nm_produk')    
                                    <span class="text-danger">{{ $message }}</span>
                                    @enderror
                            </div>

                            <div class="form-group col-md-6">
                                <label for="kd_produk">Kode Product</label>
                                <input type="text" wire:model='kd_produk' class="form-control @error('kd_produk')
                                    is-invalid
                                @enderror" id="kd_produk"
                                    placeholder="Masukan Kode Product">
                                    @error('kd_produk')    
                                    <span class="text-danger">{{ $message }}</span>
                                    @enderror
                            </div>
                        </div>


                        <div class="row">
                            <div class="form-group col-md-6">
                                <label for="harga">Harga Product <span class="text-danger small">(Opsional Jika Produk Tidak Memiliki Toping)</span></label>
                                <input type="text" id="harga" wire:model.defer="harga" class="form-control @error('harga')
                                    is-invalid
                                @enderror" id="harga"
                                    placeholder="Masukan Harga Product" oninput="format(this)">
                                    @error('harga')    
                                    <span class="text-danger">{{ $message }}</span>
                                    @enderror
                            </div>

                            <div class="form-group col-md-6">
                                <label for="stok">Stok Product</label>
                                <input type="text" wire:model='stok' class="form-control @error('stok')
                                    is-invalid
                                @enderror" id="stok"
                                    placeholder="Masukan Stok Product">
                                    @error('stok')    
                                    <span class="text-danger">{{ $message }}</span>
                                    @enderror
                            </div>
                        </div>


                        <div class="row">
                            <div class="form-group col-md-6">
                                <label for="exampleInputFile">Image</label>
                                <div class="input-group">
                                    <div class="custom-file">
                                        <input type="file" class="custom-file-input @error('image')
                                            is-invalid
                                        @enderror" id="exampleInputFile" wire:model='image'>
                                        @error('image')    
                                        <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                        <label class="custom-file-label" for="exampleInputFile">Cari Gambar</label>
                                    </div>  
                                </div>
    
                                <div class="mt-3">
                                    @if($image && $image->isPreviewable())
                                        <img src="{{ $image->temporaryUrl() }}" class="img-fluid" width="150" alt="">
                                    @endif
                                </div>
    
                            </div>

                            <div class="form-group col-md-6">
                                <label for="kategori">Kategori Product</label>
                                <select class="form-select form-control @error('id_kategori')
                                    is-invalid
                                @enderror" wire:model='id_kategori' aria-label="Default select example">
                                    <option selected>Pilih Kategori Product</option>
                                    @foreach ($kategori as $item)
                                    <option value="{{ $item->id }}">{{ $item->categori }}</option>
                                    @endforeach
                                  </select>

                                  @error('id_kategori')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                            </div>
                        </div>

                    </div>
                    <!-- /.card-body -->

                    <div class="card-footer">
                        <button class="btn btn-primary w-100">Tambah</button>
                    </div>
                </form>
            </div>
            <!-- /.card -->


            <!-- /.card -->

        </div>

        


    </div>

    

</div>

{{-- number input --}}
<script>
    function format(el) {
        let angka = el.value.replace(/\D/g, '');
        let format = new Intl.NumberFormat('id-ID').format(angka);
        el.value = format;

        // Kirim nilai asli ke Livewire
        let inputEvent = new Event('input', { bubbles: true });
        el.dispatchEvent(inputEvent);
    }

    document.addEventListener('livewire:load', function () {
        let input = document.getElementById('harga');
        if (input) {
            input.value = new Intl.NumberFormat('id-ID').format(input.value.replace(/\D/g, ''));
        }
    });
</script>