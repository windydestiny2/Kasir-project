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
            <input type="text" class="form-control form-control-sm" placeholder="Cari Kategori"
              wire:model.live.debounce.300ms="search">
          </div>
        </div>
  
        <!-- /.card-header -->
        <div class="card-body">
          <table id="" class="table table-bordered table-striped">
            <thead>
              <tr>
                <th>Nomor</th>
                <th>Jenis Kategori</th>
                <th>Aksi</th>
              </tr>
            </thead>
  
            <tbody>
  
              @foreach ($categories as $key => $category)
              <tr>
                <td>{{ $categories->firstItem() + $key }}</td>
                <td>{{ $category->categori }}</td>
                <td>
                  <a href="{{ route('edit.kategori', $category->id) }}" class="btn btn-warning">Edit</a>
                  <button class="btn btn-danger" wire:click='DeleteKategori({{ $category->id }})'
                    onclick="if(!confirm('Apakah Yakin Ingin Dihapus?')) event.stopImmediatePropagation()">Hapus</button>
                </td>
              </tr>
              @endforeach
            </tbody>
  
          </table>
          <div class="py-2">
            <div>{{ $categories->links() }}</div>
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

