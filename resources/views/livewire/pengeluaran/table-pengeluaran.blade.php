<div>
    {{-- Be like water. --}}
    <div class="col-12">

        <!-- /.card -->
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Tabel Pengeluaran</h3>
            </div>

            <!-- /.card-header -->
            <div class="container ml-1 mt-2">
                <div class="row">
                        <div class="col-12 col-md-6">
                            <input type="date" class="form-control form-control-sm" placeholder="Cari Transaksi"
                                wire:model.lazy="search">
                        </div>
                        <div class="col-12 col-md-6">
                            <a href="{{ route('cetak.pengeluaran', ['search' => $search]) }}" target="_blank" class="btn btn-primary">Cetak</a>
                        </div>
    
                </div>
            </div>


            <div class="card-body">
                <div class="table-responsive">
                    <table id="" class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th>Nomor</th>
                                <th>Tanggal</th>
                                <th>Jumlah</th>
                                <th>Keterangan</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>

                        <tbody>

                            @foreach ($pengeluaran as $key => $item)
                                <tr>
                                    <td>{{ $pengeluaran->firstItem() + $key }}</td>
                                <td>{{ $item->tanggal }}</td>
                                <td>Rp {{ number_format($item->jumlah, 0, ',', '.') }}</td>
                                <td>{{ $item->keterangan }}</td>
                                <td>
                                    <a href="{{ route('edit.Pengeluaran', $item->id) }}" class="btn btn-warning">Edit</a>
                                    <button class="btn btn-danger" wire:click='DeletePengeluaran({{ $item->id }})'
                                        onclick="if(!confirm('Apakah Yakin Ingin Dihapus?')) event.stopImmediatePropagation()">Hapus</button>
                                </td>
                                </tr>
                            @endforeach
                        </tbody>

                    </table>

                    <div class="py-2">
                        {{ $pengeluaran->links() }}
                    </div>
                </div>


                


            </div>
            <!-- /.card-body -->
        </div>
        <!-- /.card -->
    </div>
</div>
