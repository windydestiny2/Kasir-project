<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Laporan </title>

  <!-- Google Font: Source Sans Pro -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="{{ asset('asset/plugins/fontawesome-free/css/all.css') }}">
  <!-- AdminLTE -->
  <link rel="stylesheet" href="{{ asset('asset/dist/css/adminlte.css') }}">
</head>
<body>
<div class="wrapper">
  <!-- Main content -->
  <section class="invoice p-4">
    <!-- Title row -->
    <div class="row mb-4">
      <div class="col-6">
        <h2>
          <i class="fas fa-store text-primary"></i> Sugoiiyaki
        </h2>
      </div>
      <div class="col-6 text-right">
        <h5>Tanggal Cetak: <span class="text-muted">{{ $tglCetak }}</span></h5>
      </div>
    </div>

    <!-- Report Title -->
    <div class="row mb-3">
      <div class="col-12 text-center">
        <h3 class="font-weight-bold">Laporan Pengeluaran "Sugoiiyaki"</h3>
        <hr>
      </div>
    </div>

    <!-- Order Table -->
    <div class="row">
      <div class="col-12">
        <table class="table table-striped">
          <div class="header">
            @if($search)
            <p class="text-center">Laporan Pengeluaran Tanggal {{ $search }}</p>
            @else
            <p class="text-center">Laporan Semua Pengeluaran</p>
            @endif
          </div>
          <thead>
            <tr>
              <th>No</th>
              <th>Tanggal</th>
              <th>Jumlah</th>
              <th>Keterangan</th>
            </tr>
          </thead>
          <tbody>
            @foreach ($pengeluaran as $key => $item)
            <tr>
              <td>{{ $key + 1 }}</td>
              <td>{{ $item->tanggal }}</td>
              <td>{{ number_format($item->jumlah, 0, ',', '.') }}</td>
              <td>{{ $item->keterangan }}</td>
            </tr>
            @endforeach
           
          </tbody>
        </table>
      </div>
    </div>

    <!-- Payment and Totals -->
    <div class="row mt-4">
      <div class="col-6">
      </div>

      <div class="col-6">
        <p class="lead">Detail Pendapatan</p>
        <div class="table-responsive">
          <table class="table">
            <tr>
              <th style="width:50%">Pemasukan</th>
              <td>Rp {{ number_format($orders->sum('total'), 0, ',', '.') }} </td>
            </tr>

            <tr>
                <th style="width:50%">Pengeluaran</th>
                <td>Rp {{ number_format($pengeluaran->sum('jumlah'), 0, ',', '.') }}</td>
              </tr>


            <tr class="font-weight-bold text-primary">
              <th>Saldo:</th>
              <td>Rp {{ number_format($saldo, 0, ',', '.') }}</td>
            </tr>
          </table>
        </div>
      </div>

    </div>
  </section>
</div>

<!-- Auto Print -->
<script type="text/javascript">
    window.print();
</script>


</body>
</html>


