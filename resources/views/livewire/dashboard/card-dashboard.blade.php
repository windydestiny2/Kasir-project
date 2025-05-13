<div>
  <div class="row">
    <div class="col-lg-3 col-6">
      <!-- small box -->
      <div class="small-box bg-info">
        <div class="inner">
          <h3>{{ $soldDay }}<sup style="font-size: 20px">Pesanan</sup></h3>

          <p>Penjualan Hari Ini</p>
          <p>Pendapatan : Rp {{ number_format($incomeDay, 0, ',', '.') }}</p>
        </div>
        <div class="icon">
          <i class="ion ion-bag"></i>
        </div>
        <a href="#" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
      </div>
    </div>
    <!-- ./col -->
    <div class="col-lg-3 col-6">
      <!-- small box -->
      <div class="small-box bg-success">
        <div class="inner">
          <h3>{{ $totalMonth }}<sup style="font-size: 20px">Pesanan</sup></h3>
          <p>Penjualan Bulan Ini</p>
          <p>Pendapatan : Rp {{ number_format($incomeMonth, 0, ',', '.') }}</p>
        </div>
        <div class="icon">
          <i class="ion ion-stats-bars"></i>
        </div>
        <a href="#" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
      </div>
    </div>
    <!-- ./col -->
    <div class="col-lg-3 col-6">
      <!-- small box -->
      <div class="small-box bg-warning">
        <div class="inner">
          <h3>{{ $totalYear }}<sup style="font-size: 20px">Pesanan</sup></h3>

          <p>Penjualan Tahun Ini</p>
          <p>Pendapatan : Rp {{ number_format($incomeYear, 0, ',', '.') }}</p>
        </div>
        <div class="icon">
          <i class="fas fa-shopping-cart"></i>
        </div>
        <a href="#" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
      </div>
    </div>
    <!-- ./col -->
    <div class="col-lg-3 col-6">
      <!-- small box -->
      <div class="small-box bg-danger">
        <div class="inner">
          <h3>{{ $totalProduct }}<sup style="font-size: 20px">Produk</sup></h3>

          <p>Dari semua total</p>
          <p>{{ count($categories) }} Kategori</p>
        </div>
        <div class="icon">
          <i class="fas fa-tags"></i>
        </div>
        <a href="#" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
      </div>
    </div>
    <!-- ./col -->
  </div>

  <div class="row">
    <div class="col-lg-4 col-6">
        <!-- small box -->
        <div class="small-box bg-secondary">
            <div class="inner">
                <h3>Rp {{ number_format($pemasukan, 0, ',', '.') }}</h3>
                <p>Total Pemasukan</p>
            </div>
            <div class="icon">
                <i class="fas fa-arrow-alt-circle-up"></i>
            </div>
            <a href="#" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
        </div>
    </div>

    <!-- ./col -->
    <div class="col-lg-4 col-6">
        <!-- small box -->
        <div class="small-box bg-danger">
            <div class="inner">
                <h3>Rp {{ number_format($pengeluaran, 0, ',', '.') }}</h3>
                <p>Pengeluaran </p>
            </div>
            <div class="icon">
                <i class="fas fa-arrow-alt-circle-down"></i>
            </div>
            <a href="#" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
        </div>
    </div>

    <!-- ./col -->
    <div class="col-lg-4 col-6">
        <!-- small box -->
        <div class="small-box bg-primary">
            <div class="inner">
                <h3>Rp {{ number_format($saldoAkhir, 0, ',', '.') }}</h3>
                <p>Saldo akhir</p>
            </div>
            <div class="icon">
                <i class="fas fa-money-bill-wave"></i>
            </div>
            <a href="#" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
        </div>
    </div>
    <!-- ./col -->

    <!-- ./col -->
</div>
</div>