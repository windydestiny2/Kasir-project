@extends('Backend.main-master')

@push('styles')
@endpush

@push('scripts')
@endpush

@section('content')

<div class="content-wrapper">
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Riwayat & Laporan Pesanan</h1>
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                        <li class="breadcrumb-item active">Riwayat & Laporan</li>
                    </ol>
                </div><!-- /.col -->
            </div><!-- /.row -->
        </div><!-- /.container-fluid -->
    </div>

    <section class="content">
        <div class="container-fluid">

            {{-- <div class="card">
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
                                <a href="" class="btn btn-primary">Cetak</a>
                            </div>

                    </div>
                </div>

                <div class="card-body p-2">
                    <div class="table-responsive">
                        <table id="example2" class="table table-bordered table-striped">
                            <thead>
                                <tr>
                                    <th>Nomor</th>
                                    <th>Nama Kasir</th>
                                    <th>Total Pesanan</th>
                                    <th>Tanggal Pemesanan</th>
                                    <th>Status</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>

                            <tbody>
                                @foreach ($orders as $key => $item) 
                                <tr>
                                    <td>{{ $key + 1 }}</td>
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
                    </div>

                    <div class="py-2">

                    </div>
                </div>
                <!-- /.card-body -->
            </div> --}}

            @livewire('reports.CariTransaksi')

            
            
            {{-- @livewire('Order.order-pesanan') --}}

            {{-- @livewire('Order.menu-order-table') --}}
        </div>
    </section>
</div>

@endsection