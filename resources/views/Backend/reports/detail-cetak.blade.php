<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Detail Cetak</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Font Awesome -->
    <link rel="stylesheet" href="{{ asset('asset/plugins/fontawesome-free/css/all.css') }}">
    <!-- AdminLTE -->
    <link rel="stylesheet" href="{{ ('asset/dist/css/adminlte.css') }}">
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f8f9fa;
            padding: 30px;
        }

        .receipt {
            background: #fff;
            padding: 30px;
            border-radius: 8px;
            width: 21cm;
            min-height: 29.7cm;
            margin: auto;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        .receipt h5 {
            font-weight: bold;
        }

        .receipt .text-muted {
            font-size: 0.9rem;
        }

        .qr {
            text-align: center;
            margin-top: 30px;
        }

        .btn-retur {
            background-color: #0ca678;
            color: white;
            font-weight: bold;
            width: 100%;
        }

        @media print {
            body {
                background: none;
                padding: 0;
            }

            .receipt {
                box-shadow: none;
                margin: 0;
                width: 100%;
                padding: 0;
            }

            .btn-retur {
                display: none;
            }
        }
    </style>
</head>

<body>

    <section class="content">
        <div class="container-fluid">
            <div class="receipt">
                <div class="text-center mb-3">
                    <img src="https://img.icons8.com/color/96/shop.png" width="60" alt="Logo Toko">
                    <h5>Kedai Sugoiiyaki</h5>
                    <div class="text-muted">Jl. Puri Nirwana 1 blok A no.4</div>
                    <div class="text-muted">+62 851 7329 0889</div>
                </div>

                <div class="d-flex justify-content-between">
                    <div>
                        <div class="text-muted fw-bold">Tanggal Pesan</div>
                        <div class="text-muted">{{ $orders->created_at }}</div>
                    </div>
                    <div class="text-end">
                        <h6 class="fw-bold">{{ Auth::user()->job }}</h6>
                        <div class="text-muted">{{ Auth::user()->name }}</div>
                        {{-- <div class="text-muted">Jl. Anggrek No. 45, Sepanjang</div> --}}
                    </div>
                </div>

                <hr>
                
                <div class="card-header py-2">
                    <h6 class="card-title fw-bold">Detail Pesanan</h6>
                </div>
                
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
                                        <td>{{ $item->Ukuran?->toping?->name_toping ?? '-' }}</td>
                                        <td>{{ $item->Ukuran?->nama ?? '-' }}</td>
                                        <td>
                                            @if ($item->Ukuran)
                                                Rp {{ number_format($item->Ukuran->harga, 0, ',', '.') }}
                                            @else
                                                -
                                            @endif
                                        </td>
                                        <td>{{ $item->qty }}</td>
                                        <td>
                                            @if ($item->Ukuran)
                                                Rp {{ number_format($item->Ukuran->harga * $item->qty, 0, ',', '.') }}
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
    
                                
                            </tbody>
    
    
                           
    
                        </table>
                    </div>
                </div>


            </div>
            
        </div>
    </section>

</body>

<script>
    window.print();
</script>

</html>

