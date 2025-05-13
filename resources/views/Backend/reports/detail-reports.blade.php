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
                    <h1 class="m-0">Detail Pesanan</h1>
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                        <li class="breadcrumb-item active">Detail Pesanan</li>
                    </ol>
                </div><!-- /.col -->
            </div><!-- /.row -->
        </div><!-- /.container-fluid -->
    </div>

    <section class="content">
        <div class="container-fluid">

            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Detail Pesanan</h3>
                </div>
                <!-- /.card-header -->
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th>Gambar Produk</th>
                                    <th>Nama Produk</th>
                                    <th>Kode Produk</th>
                                    <th>Toping</th>
                                    <th>Ukuran</th>
                                    <th>Harga Ukuran</th>
                                    <th>Jumlah</th>
                                    <th>Harga Produk</th>
                                </tr>
                            </thead>
    
                            <tbody>
                                @foreach ($orders->orderitem as $item)
                                    <tr>
                                        <td>
                                            <img src="{{ asset('storage/'. $item->product->image) }}" alt="image" width="50" height="50">
                                        </td>
                                        <td>{{ $item->product->nm_produk }}</td>
                                        <td>{{ $item->product->kd_produk }}</td>
                                        <td>{{ $item->ukuran?->toping?->name_toping ?? '-' }}</td>
                                        <td>{{ $item->ukuran?->nama ?? '-' }}</td>
                                        <td>
                                            @if ($item->ukuran)
                                                Rp {{ number_format($item->ukuran->harga, 0, ',', '.') }}
                                            @else
                                                -
                                            @endif
                                        </td>
                                        <td>{{ $item->qty }}</td>
                                        <td>
                                            @if ($item->ukuran)
                                                Rp {{ number_format($item->ukuran->harga * $item->qty, 0, ',', '.') }}
                                            @else
                                                Rp {{ number_format($item->product->harga * $item->qty, 0, ',', '.') }}
                                            @endif
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
    
                                
                            
    
                            <tbody>
                                <tr>
                                    <th colspan="4">Total Belanja</th>
                                    <td colspan="4">Rp {{ number_format($orders->total, 0, ',', '.') }}</td>
                                </tr>
                                <tr>
                                    <th colspan="4">Total Bayar</th>
                                    <td colspan="4">Rp {{ number_format($orders->total_bayar, 0, ',', '.') }} </td>
                                </tr>
                                <tr>
                                    <th colspan="4">Kembalian</th>
                                    <td colspan="4">Rp {{ number_format($orders->kembalian, 0, ',', '.') }}</td>
                                </tr>
    
                                <tr>
                                    <th>
                                        <a href="{{ route('detail.cetak', $orders->id) }}" class="btn btn-success" target="_blank">Cetak</a>
                                    </th>
                                </tr>
                            </tbody>
    
    
                           
    
                        </table>
                    </div>
                </div>
                <!-- /.card-body -->
            </div>
            
            {{-- @livewire('Order.order-pesanan') --}}

            {{-- @livewire('Order.menu-order-table') --}}
        </div>
    </section>
</div>

@endsection