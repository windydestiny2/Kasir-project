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
              <input type="text" class="form-control form-control-sm" placeholder="Cari Toping"
                wire:model.live.debounce.300ms="search">
            </div>
          </div>
    
          <!-- /.card-header -->
          <div class="card-body">
            <table id="example1" class="table table-bordered table-striped">
              <thead>
                <tr>
                  <th>Nomor</th>
                  <th>Product</th>
                  <th>Toping</th>
                  <th>Aksi</th>
                </tr>
              </thead>
    
              <tbody>
    
                @foreach ($topings as $key => $toping)
                <tr>
                  <td>{{ $topings->firstItem() + $key }}</td>
                  <td>{{ $toping->product->nm_produk }}</td>
                  <td>{{ $toping->name_toping }}</td>
                  <td>
                    <a href="{{ route('edit.toping', $toping->id) }}" class="btn btn-warning">Edit</a>
                    <button class="btn btn-danger" wire:click='DeleteToping({{ $toping->id }})'
                      onclick="if(!confirm('Apakah Yakin Ingin Dihapus?')) event.stopImmediatePropagation()">Hapus</button>
                  </td>
                </tr>
                @endforeach
              </tbody>
              
              <div class="py-2">
                <div>{{ $topings->links() }}</div>
              </div>
            </table>

            
          </div>
    
          
          <!-- /.card-body -->
        </div>
    
    
        <!-- /.card -->
      </div>
    </div>
  </div>
  
  
  
  