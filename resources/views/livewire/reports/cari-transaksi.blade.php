<div>
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">Daftar Pemesanan</h3>
        </div>

        <!-- /.card-header -->

        <div class="container ml-1 mt-2">
            <div class="row">
                    <div class="col-12 col-md-6">
                        <input type="date" class="form-control form-control-sm" placeholder="Cari Transaksi"
                            wire:model.lazy="search">
                    </div>
                    <div class="col-12 col-md-6">
                        <a href="{{ route('cetak.reports', ['search' => $search]) }}" target="_blank" class="btn btn-primary">Cetak</a>
                    </div>

            </div>
        </div>

        <div class="card-body p-2">
            <div class="table-responsive">
                <table id="" class="table table-bordered table-striped">
                    <thead>
                        <tr>
                            <th>Nomor</th>
                            <th>Nama Kasir</th>
                            <th>Total Pesanan</th>
                            <th>Tanggal Pemesanan</th>
                            <th>Catatan</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>

                    <tbody>
                        @foreach ($orders as $key => $item) 
                        <tr>
                            <td>{{ $orders->firstItem() + $key }}</td>
                            <td>{{ $item->user->name }}</td>
                            <td>Rp {{ number_format($item->total, 0, ',', '.') }}</td>
                            <td>{{ $item->created_at }}</td>
                            <td>{{ $item->status }}</td>
                            <td>
                                <a href="{{ route('detail.report', $item->id) }}" class="btn btn-primary">Detail</a>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>

                </table>

                <div class="py-2">
                    {{ $orders->links() }}
                </div>
            </div>

            
        </div>
        <!-- /.card-body -->
    </div>

</div>
</div>
