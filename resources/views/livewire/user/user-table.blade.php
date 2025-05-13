<div>
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">Daftar Admin</h3>
        </div>

        <!-- /.card-header -->

        <div class="container ml-1 mt-2">
            <div class="row">
                    <div class="col-12 col-md-6">
                        <input type="text" class="form-control form-control-sm" placeholder="Cari Admin"
                            wire:model.live.debounce.300ms="search">
                    </div>
            </div>
        </div>

        <div class="card-body p-2">
            <div class="table-responsive">
                <table id="" class="table table-bordered table-striped">
                    <thead>
                        <tr>
                            <th>Nomor</th>
                            <th>Nama</th>
                            <th>Email</th>
                            <th>Hak Akses</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>

                    <tbody>
                        @foreach ($users as $key => $user)
                        <tr>
                                <td>{{ $users->firstItem() + $key }}</td>
                                <td>{{ $user->name }}</td>
                                <td>{{ $user->email }}</td>
                                <td>
                                    @if($user->dashboard == 1)
                                        <span class="badge btn-primary">Dashboard</span>
                                    @endif
                                    @if($user->admin == 1)
                                        <span class="badge btn-success">Admin</span>
                                    @endif
                                    @if($user->product == 1)
                                        <span class="badge btn-danger">Product</span>
                                    @endif
                                    @if($user->kategori == 1)
                                        <span class="badge btn-dark">Kategori</span>
                                    @endif
                                    @if($user->orderpes == 1)
                                        <span class="badge btn-warning">Order Pesanan</span>
                                    @endif
                                    @if($user->riwayat == 1)
                                        <span class="badge btn-danger">Riwayat & Laporan</span>
                                    @endif
                                    @if($user->pengeluaran == 1)
                                        <span class="badge btn-secondary">Pengeluaran</span>
                                    @endif
                                    @if($user->toping == 1)
                                        <span class="badge btn-success">Toping</span>
                                    @endif
                                    @if($user->ukuran == 1)
                                        <span class="badge btn-primary">Ukuran</span>
                                    @endif
                                </td>

                                <td>
                                    <a href="{{ route('edit.user', $user->id) }}" class="btn btn-warning">Edit</a>
                                    <button class="btn btn-danger" wire:click='DeleteUser({{ $user->id }})'
                                        onclick="confirm('Yakin Ingin Menghapus') || event.stopImmediatePropagation">Hapus</button>
                                </td>
                            </tr>
                            @endforeach
                    </tbody>

                </table>

                <div class="py-2">
                    {{ $users->links() }}
                </div>
            </div>

            
        </div>
        <!-- /.card-body -->
    </div>
</div>
