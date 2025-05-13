<div>
  {{-- In work, do what you enjoy. --}}
  <div class="col-12">

    <!-- /.card -->
    <div class="card">
      <div class="card-header">
        <h3 class="card-title">Tabel Produk</h3>
      </div>

      <!-- /.card-header -->
      <div class="container mt-3">
        <div class="col-sm-12 col-md-6">
          <input type="text" class="form-control form-control-sm" placeholder="Cari Produk" wire:model.live.debounce.300ms="search">
          </div>
      </div>


      <div class="card-body">
        <div class="table-responsive">
          <table id="" class="table table-bordered table-striped">
            <thead>
              <tr>
                <th>Nomor</th>
                <th>Nama Produk</th>
                <th>Kategori</th>
                <th>Harga</th>
                <th>Stok</th>
                <th>Kode Produk</th>
                <th>Image</th>
                <th>Barcode</th>
                <th>Aksi</th>
              </tr>
            </thead>
  
            <tbody>
  
              @foreach ($products as $key => $product)
              <tr>
                <td>{{ $products->firstItem() + $key }}</td>
                <td>{{ $product->nm_produk }}</td>
                <td>{{ $product->kategori->categori }}</td>
                <td>Rp {{ number_format($product->harga, 0, ',', '.') }}</td>
                <td>{{ $product->stok }}</td>
                <td>{{ $product->kd_produk }}</td>
                <td>
                  <img src="{{ asset('storage/'. $product->image) }}" class="img-fluid" width="50" alt="">
                </td>

                <td>
                  <div class="d-flex flex-column align-items-center">
                    <img src="{{ asset('storage/' . $product->barcode) }}" class="img-thumbnail mb-1" width="80" alt="Barcode">
                    <a 
                      href="{{ asset('storage/' . $product->barcode) }}" 
                      download="barcode_{{ $product->nm_produk }}.png" 
                      class="btn btn-sm btn-outline-success"
                    >
                      Download
                    </a>
                  </div>
                </td>
                
                <td>
                  <a href="{{ route('edit.product', $product->id) }}" class="btn btn-warning">Edit</a>
                  <button class="btn btn-danger" wire:click='DeleteProduct({{ $product->id }})'
                    onclick="if(!confirm('Apakah Yakin Ingin Dihapus?')) event.stopImmediatePropagation()">Hapus</button>
                    
                </td>
              </tr>
              @endforeach
            </tbody>
  
          </table>

          <div class="py-2">
            {{ $products->links() }}
          </div>
        </div>

        
      </div>
      <!-- /.card-body -->
    </div>
    <!-- /.card -->
  </div>
</div>