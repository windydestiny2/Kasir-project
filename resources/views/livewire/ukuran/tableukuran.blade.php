<div wire:noscroll>
    <div class="row">
      <div class="col-12">
  
        <!-- /.card -->
        <div class="card">
          <div class="card-header">
            <h3 class="card-title">DataTable with default features</h3>
          </div>
    
          <div class="container mt-3">
            <div class="col-sm-12 col-md-6">
              <input type="text" class="form-control form-control-sm" placeholder="Cari Ukuran"
                wire:model.live.debounce.300ms="search">
            </div>
          </div>
    
          <!-- /.card-header -->
          <div class="card-body">
            <table id="" class="table table-bordered table-striped">
              <thead>
                <tr>
                  <th>Nomor</th>
                  <th>Product</th>
                  <th>Toping</th>
                  <th>Ukuran</th>
                  <th>Harga</th>
                </tr>
              </thead>
    
              <tbody>
    
                @foreach ($Ukurans as $key => $Ukuran)
                <tr>
                  <td>{{ $Ukurans->firstItem() + $key }}</td>
                  <td>{{ $Ukuran->product->nm_produk }}</td>
                  <td>{{ $Ukuran->toping->name_toping }}</td>
                  <td>{{ $Ukuran->nama }}</td>
                  <td>Rp {{ number_format($Ukuran->harga, 0, ',','.') }}</td>
                  <td>
                    <a href="{{ route('edit.Ukuran', $Ukuran->id) }}" class="btn btn-warning">Edit</a>
                    <button class="btn btn-danger" wire:click='DeleteUkuran({{ $Ukuran->id }})'
                      onclick="if(!confirm('Apakah Yakin Ingin Dihapus?')) event.stopImmediatePropagation()">Hapus</button>
                  </td>
                </tr>
                @endforeach
              </tbody>
    
            </table>

            <div class="py-2">
              <div>{{ $Ukurans->links() }}</div>
            </div>
          </div>
    
          
          <!-- /.card-body -->
        </div>
    
    
        <!-- /.card -->
      </div>
    </div>
  </div>
  
  <script>
    document.addEventListener('click', function (e) {
      if (e.target.closest('.pagination a')) {
        e.preventDefault();
        const url = e.target.getAttribute('href');
        if (url) {
          Livewire.visit(url);
        }
      }
    });
  </script>
  
  