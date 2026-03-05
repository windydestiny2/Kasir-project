<div>
  <div class="col-12">

    <!-- /.card -->
    <div class="card">
      <div class="card-header">
        <h3 class="card-title">Daftar Pesanan</h3>
      </div>

      <!-- /.card-header -->
      <div class="card-body">
        <table id="example1" class="table table-bordered table-striped">
          <thead>
            <tr>
              <th>Nomor</th>
              <th>Nama Produk</th>
              <th>Harga</th>
              <th>Stok</th>
              <th>Image</th>
              <th>Aksi</th>
            </tr>
          </thead>

          <tbody >

            @foreach ($products as $key => $product)
            <tr>
              <td>{{ $key + 1 }}</td>
              <td>{{ $product->nm_produk }}</td>
              <td>{{ $product->harga }}</td>
              <td >{{ $product->stok }}</td>

              <td>
                <img src="{{ asset('storage/'. $product->image) }}" class="img-fluid" width="50" alt="">
              </td>

              <td>
                
                @livewire('order.tambah-order', ['id_product' => $product->id])
                {{-- @livewire('Order.bayar-pesanan') --}}

              </td>
            </tr>
            @endforeach
          </tbody>

        </table>
      </div>
      <!-- /.card-body -->
    </div>
    <!-- /.card -->
  </div>
</div>



