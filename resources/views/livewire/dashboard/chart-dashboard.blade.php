<div>
    <div class="row">
        {{-- data produk perhari --}}
        <div class="col-lg-6">
            <div class="card">
                <div class="card-header border-0">
                    <div class="d-flex justify-content-between">
                        <h3 class="card-title">Data Penjualan Hari ini</h3>
                    </div>
                </div>
                <div class="card-body">
                    <!-- /.d-flex -->
                    <div class="position-relative mb-4">
                        <div class="chartjs-size-monitor">
                            <div class="chartjs-size-monitor-expand">
                                <div class=""></div>
                            </div>
                            <div class="chartjs-size-monitor-shrink">
                                <div class=""></div>
                            </div>
                        </div>
                        <canvas id="day-chart" wire:ignore height="100" width="721"
                            style="display: block; width: 721px; height: 200px;"
                            class="chartjs-render-monitor"></canvas>
                    </div>
                </div>
            </div>
        </div>

        {{-- produk perbulan --}}
        <div class="col-lg-6">
            <div class="card">
                <div class="card-header border-0">
                    <div class="d-flex justify-content-between">
                        <h3 class="card-title">Daftar Penjualan Produk Bulan ini </h3>
                    </div>
                </div>
                <div class="card-body">
                    <!-- /.d-flex -->
                    <div class="position-relative mb-4">
                        <div class="chartjs-size-monitor">
                            <div class="chartjs-size-monitor-expand">
                                <div class=""></div>
                            </div>
                            <div class="chartjs-size-monitor-shrink">
                                <div class=""></div>
                            </div>
                        </div>
                        <canvas id="month-chart" wire:ignore height="100" width="721"
                            style="display: block; width: 721px; height: 200px;"
                            class="chartjs-render-monitor"></canvas>
                    </div>
                </div>
            </div>
        </div>
    </div>



    <div class="row">
        {{-- produk pertahun --}}
        <div class="col-lg-6">
            <div class="card">
                <div class="card-header border-0">
                    <div class="d-flex justify-content-between">
                        <h3 class="card-title">Data Penjualan Tahun {{ $year->format('Y') }}</h3>
                    </div>
                </div>
                <div class="card-body">
                    <div class="d-flex">
                        <p class="d-flex flex-column">
                            <span class="text-bold text-lg">Rp {{ number_format($totalCount, 0, ',', '.') }}</span>
                            <span>Total Pendapatan Tahun ini</span>
                        </p>

                    </div>
                    <!-- /.d-flex -->

                    <div class="position-relative mb-4">
                        <div class="chartjs-size-monitor">
                            <div class="chartjs-size-monitor-expand">
                                <div class=""></div>
                            </div>
                            <div class="chartjs-size-monitor-shrink">
                                <div class=""></div>
                            </div>
                        </div>
                        <canvas id="year-chart" wire:ignore height="100" width="721"
                            style="display: block; width: 721px; height: 200px;"
                            class="chartjs-render-monitor"></canvas>
                    </div>
                </div>
            </div>
        </div>

        {{-- produk terlaris --}}
        <div class="col-lg-6">
            <div class="card">
                <div class="card-header border-0">
                    <div class="d-flex justify-content-between">
                        <h3 class="card-title">Data Produk Terlaris {{ $year->format('Y') }}</h3>
                    </div>
                </div>
                <div class="card-body">
                    <!-- /.d-flex -->

                    <div class="position-relative mb-4">
                        <div class="chartjs-size-monitor">
                            <div class="chartjs-size-monitor-expand">
                                <div class=""></div>
                            </div>
                            <div class="chartjs-size-monitor-shrink">
                                <div class=""></div>
                            </div>
                        </div>
                        <canvas id="best-chart" wire:ignore height="100" width="721"
                            style="display: block; width: 721px; height: 200px;"
                            class="chartjs-render-monitor"></canvas>
                    </div>
                </div>
            </div>
        </div>

    </div>


    <div class="row">
        {{-- pengeluaran & pemasukan --}}
        <div class="col-lg-6">
            <div class="card">
                <div class="card-header border-0">
                    <div class="d-flex justify-content-between">
                        <h3 class="card-title">Data Pengeluaran & Pemasukan</h3>
                    </div>
                </div>
                <div class="card-body">
                    <!-- Informasi Pendapatan dan Pengeluaran -->
                    <div class="d-flex justify-content-around mb-3">
                        <div class="text-center">
                            <p class="d-flex flex-column m-0">
                                <span class="text-bold text-lg">Rp {{ number_format($totalPendapatan, 0, ',', '.') }}</span>
                                <span>Pendapatan</span>
                            </p>
                        </div>
                        <div class="text-center">
                            <p class="d-flex flex-column m-0">
                                <span class="text-bold text-lg">Rp {{ number_format($pengeluaran, 0, ',', '.') }}</span>
                                <span>Pengeluaran</span>
                            </p>
                        </div>
                    </div>
        
                    <!-- Chart -->
                    <div class="position-relative mb-4">
                        <canvas id="pengeluaran-chart" wire:ignore height="100" width="721"
                            style="display: block; width: 100%; height: 200px;"
                            class="chartjs-render-monitor"></canvas>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-lg-6">
            <div class="card">
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
    
                                @foreach ($Datapengeluaran as $key => $item)
                                    <tr>
                                        <td>{{ $Datapengeluaran->firstItem() + $key }}</td>
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
                            {{ $Datapengeluaran->links() }}
                        </div>
                    </div>
    
    
                    
    
    
                </div>
            </div>
        </div>
        


    </div>


</div>


{{-- pengeluaran char --}}
<script>
    var dataInOut = {!! $dataInOut !!};

    const data = {
        labels: [
           'Pemasukan',
           'Pengeluaran',
        ],
        datasets: [{
            label: 'Data Keuangan',
            data: [dataInOut.pemasukan, dataInOut.pengeluaran],
            backgroundColor: [
                'rgb(75, 192, 192)',
                'rgb(255, 99, 132)',
            ],
            hoverOffset: 4
        }]
    };

    const config = {
        type: 'pie',
        data: data,

        options: {
            plugins: {
                tooltip: {
                    callbacks: {
                        label: function(context) {
                            let label = context.label || '';
                            let value = context.parsed || 0;

                            // Format Rupiah
                            let formatted = new Intl.NumberFormat('id-ID', {
                                style: 'currency',
                                currency: 'IDR'
                            }).format(value);

                            return `${label}: ${formatted}`;
                        }
                    }
                }
            }
        }
    };

    document.addEventListener('DOMContentLoaded', function () {
        const ctx = document.getElementById('pengeluaran-chart').getContext('2d');
        window.inOutChart = new Chart(ctx, config);

        Livewire.on('phpInOut', event => {
            var dataInOut = JSON.parse(event.data);
            console.log(dataInOut);
            
            window.inOutChart.data.datasets[0].data = [dataInOut.pemasukan, dataInOut.pengeluaran];
            window.inOutChart.update();
        });        
    });

    // Panggil Livewire setiap 3 detik
    setInterval(() => Livewire.dispatch('JavascriptInOut'), 3000);
</script>




{{-- cart tahun --}}
<script>
    document.addEventListener("DOMContentLoaded", function () {
    setInterval(() => Livewire.dispatch('YearProduct'), 3000);
    var charData = {!! $orderYear !!}; // Ambil data dari PHP

    // console.log(charData); // Debugging untuk melihat data
    const getColors = (length) => {
        const colors = [
            '#17a2b8', '#6c757d', '#dc3545', '#20c997', '#6610f2',
            '#fd7e14', '#007bff', '#28a745', '#ffc107', '#e83e8c'
        ];

        return Array.from({length}, (_, i) => colors[i % colors.length]);
    }

    var ctx = document.getElementById('year-chart').getContext('2d');

    var yearChart = new Chart(ctx, {
        type: 'bar',
        data: {
            labels: charData.labelYear, // Nama produk
            datasets: [
                {
                    backgroundColor: '#007bff',
                    borderColor: '#007bff',
                    data: charData.dataYear // Jumlah produk terjual
                },
            ]
        },
        options: {
            maintainAspectRatio: false,
            tooltips: {
                mode: 'index',
                intersect: false
            },
            hover: {
                mode: 'index',
                intersect: false
            },
            legend: {
                display: false
            },
            scales: {
                yAxes: [{
                    gridLines: {
                        display: true,
                        lineWidth: '4px',
                        color: 'rgba(0, 0, 0, .2)',
                        zeroLineColor: 'transparent'
                    },
                    ticks: {
                        beginAtZero: true,
                        stepSize: 10, // Pastikan hanya menampilkan angka kelipatan 100
                        callback: function (value) {
                            return value; // Tampilkan angka tanpa format tambahan
                        }
                    }
                }],
                xAxes: [{
                    display: true,
                    gridLines: {
                        display: false
                    }
                }]
            }
        }
    });

    Livewire.on('yearWork', event => {
            var charData = JSON.parse(event.data);
            console.log(charData);
            yearChart.data.labels = charData.labelYear;
            yearChart.data.datasets.forEach((dataset) => {
                dataset.data = charData.dataYear;
                dataset.backgroundColor = getColors(charData.dataYear.length);
                dataset.borderColor = getColors(charData.dataYear.length);
            });
            yearChart.update();
        });
});

</script>


{{-- cart perhari --}}
<script>
    document.addEventListener("DOMContentLoaded", function () {
    setInterval(() => Livewire.dispatch('DayProduct'), 3000);
    var charData = {!! $orderDay !!}; // Ambil data dari PHP

    // console.log(charData); // Debugging untuk melihat data
    // Buat array warna untuk setiap bar
    const generateColors = (length) => {
        const colors = [
            '#17a2b8', '#007bff', '#dc3545', '#20c997', '#6610f2',
            '#fd7e14', '#6c757d', '#28a745', '#ffc107', '#e83e8c'
        ];   
        // Jika jumlah data lebih banyak dari warna, ulangi warna
        return Array.from({ length }, (_, i) => colors[i % colors.length]);
    };

    var ctx = document.getElementById('day-chart').getContext('2d');

    var dayChart = new Chart(ctx, {
        type: 'bar',
        data: {
            labels: charData.labelDay, // Nama produk
            datasets: [
                {
                    backgroundColor: '#007bff',
                    borderColor: '#007bff',
                    data: charData.dataDay // Jumlah produk terjual
                },
            ]
        },
        options: {
            maintainAspectRatio: false,
            tooltips: {
                mode: 'index',
                intersect: false
            },
            hover: {
                mode: 'index',
                intersect: false
            },
            legend: {
                display: false
            },
            scales: {
                yAxes: [{
                    gridLines: {
                        display: true,
                        lineWidth: '4px',
                        color: 'rgba(0, 0, 0, .2)',
                        zeroLineColor: 'transparent'
                    },
                    ticks: {
                        beginAtZero: true,
                        stepSize: 10, // Pastikan hanya menampilkan angka kelipatan 100
                        callback: function (value) {
                            return value; // Tampilkan angka tanpa format tambahan
                        }
                    }
                }],
                xAxes: [{
                    display: true,
                    gridLines: {
                        display: false
                    }
                }]
            }
        }
    });

    Livewire.on('dayWork', event => {
            var charData = JSON.parse(event.data);
            console.log(charData);
            dayChart.data.labels = charData.labelDay;
            dayChart.data.datasets.forEach((dataset) => {
                dataset.data = charData.dataDay;
                dataset.backgroundColor = generateColors(charData.dataDay.length);
                dataset.borderColor = generateColors(charData.dataDay.length);
            });
            dayChart.update();
        });
});

</script>

{{-- cart perbulan --}}
<script>
    document.addEventListener("DOMContentLoaded", function () {
    setInterval(() => Livewire.dispatch('MonthProduct'), 3000);
    var charData = {!! $orders !!}; // Ambil data dari PHP

    // console.log(charData); // Debugging untuk melihat data

    // Buat array warna untuk setiap bar
    const generateColors = (length) => {
        const colors = [
            '#007bff', '#28a745', '#dc3545', '#ffc107', '#6610f2',
            '#fd7e14', '#6c757d', '#17a2b8', '#20c997', '#e83e8c'
        ];
        // Jika jumlah data lebih banyak dari warna, ulangi warna
        return Array.from({ length }, (_, i) => colors[i % colors.length]);
    };

    var ctx = document.getElementById('month-chart').getContext('2d');

    var monthChart = new Chart(ctx, {
        type: 'bar',
        data: {
            labels: charData.label, // Nama produk
            datasets: [
                {
                    backgroundColor: '#007bff',
                    borderColor: '#007bff',
                    data: charData.data // Jumlah produk terjual
                },
            ]
        },
        options: {
            maintainAspectRatio: false,
            tooltips: {
                mode: 'index',
                intersect: false
            },
            hover: {
                mode: 'index',
                intersect: false
            },
            legend: {
                display: false
            },
            scales: {
                yAxes: [{
                    gridLines: {
                        display: true,
                        lineWidth: '4px',
                        color: 'rgba(0, 0, 0, .2)',
                        zeroLineColor: 'transparent'
                    },
                    ticks: {
                        beginAtZero: true,
                        stepSize: 10, // Pastikan hanya menampilkan angka kelipatan 100
                        callback: function (value) {
                            return value; // Tampilkan angka tanpa format tambahan
                        }
                    }
                }],
                xAxes: [{
                    display: true,
                    gridLines: {
                        display: false
                    }
                }]
            }
        }
    });

    Livewire.on('berhasil', event => {
            var charData = JSON.parse(event.data);
            console.log(charData);
            monthChart.data.labels = charData.label;
            monthChart.data.datasets.forEach((dataset) => {
                dataset.data = charData.data;
                dataset.backgroundColor = generateColors(charData.data.length);
                dataset.borderColor = generateColors(charData.data.length);
            });
            monthChart.update();
        });
});

</script>

{{-- cart best produk --}}
<script>
    document.addEventListener("DOMContentLoaded", function () {
    setInterval(() => Livewire.dispatch('BestProduct'), 3000);
    var charData = {!! $orderBest !!}; // Ambil data dari PHP

    // console.log(charData); // Debugging untuk melihat data

    // Buat array warna untuk setiap bar
    const generateColors = (length) => {
        const colors = [
            '#007bff', '#28a745', '#dc3545', '#ffc107', '#6610f2',
            '#fd7e14', '#6c757d', '#17a2b8', '#20c997', '#e83e8c'
        ];
        // Jika jumlah data lebih banyak dari warna, ulangi warna
        return Array.from({ length }, (_, i) => colors[i % colors.length]);
    };

    var ctx = document.getElementById('best-chart').getContext('2d');

    var bestChart = new Chart(ctx, {
        type: 'bar',
        data: {
            labels: charData.labelBest, // Nama produk
            datasets: [
                {
                    backgroundColor: '#007bff',
                    borderColor: '#007bff',
                    data: charData.dataBest // Jumlah produk terjual
                },
            ]
        },
        options: {
            maintainAspectRatio: false,
            tooltips: {
                mode: 'index',
                intersect: false
            },
            hover: {
                mode: 'index',
                intersect: false
            },
            legend: {
                display: false
            },
            scales: {
                yAxes: [{
                    gridLines: {
                        display: true,
                        lineWidth: '4px',
                        color: 'rgba(0, 0, 0, .2)',
                        zeroLineColor: 'transparent'
                    },
                    ticks: {
                        beginAtZero: true,
                        stepSize: 10, // Pastikan hanya menampilkan angka kelipatan 100
                        callback: function (value) {
                            return value; // Tampilkan angka tanpa format tambahan
                        }
                    }
                }],
                xAxes: [{
                    display: true,
                    gridLines: {
                        display: false
                    }
                }]
            }
        }
    });

    Livewire.on('bestProduct', event => {
            var charData = JSON.parse(event.data);
            console.log(charData);
            bestChart.data.labels = charData.labelBest;
            bestChart.data.datasets.forEach((dataset) => {
                dataset.data = charData.dataBest;
                dataset.backgroundColor = generateColors(charData.dataBest.length);
                dataset.borderColor = generateColors(charData.dataBest.length);
            });
            bestChart.update();
        });
});

</script>