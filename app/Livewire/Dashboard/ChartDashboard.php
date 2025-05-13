<?php

namespace App\Livewire\Dashboard;

use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Pengeluaran;
use App\Models\Product;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Livewire\Component;
use Livewire\WithPagination;

class ChartDashboard extends Component
{
    // public $labels = [];
    // public $data = [];

    public $orders;
    public $orderYear;
    public $orderDay;
    public $orderBest;

    public $dataInOut;

    use WithPagination;
    protected $paginationTheme = 'bootstrap';

    protected $listeners = [
        'MonthProduct' => 'changeDataMonth',
        'DayProduct' => 'changeDay',
        'YearProduct' => 'changeYear',
        'BestProduct' => 'changeBestProduct',
        'JavascriptInOut' => 'changeInOut'
    ];

    public function mount(){

        // produk pertahun
        $orderYear = OrderItem::whereYear('order_items.created_at', Carbon::now()->year)
        ->whereYear('order_items.created_at', Carbon::now()->year)
        ->join('products', 'order_items.product_id', '=', 'products.id')
        ->selectRaw('products.nm_produk as name, SUM(order_items.qty) as total_qty')
        ->groupBy('products.nm_produk')
        ->orderByDesc('total_qty')
        ->limit(10)->get();

        $dataYear = [
            'labelYear' => $orderYear->pluck('name')->toArray(),
            'dataYear' => $orderYear->pluck('total_qty')->toArray()
        ];

        // dd($dataYear);
        $this->orderYear = json_encode($dataYear);
        // dd($this->orderYear);
        

        // data perbulan
        $orders = OrderItem::whereMonth('order_items.created_at', Carbon::now()->month)
        ->whereYear('order_items.created_at', Carbon::now()->year)
        ->join('products', 'order_items.product_id', '=', 'products.id')
        ->selectRaw('products.nm_produk as name, SUM(order_items.qty) as total_qty')
        ->groupBy('products.nm_produk')
        ->orderByDesc('total_qty')
        ->limit(10)->get();
        

        $data = [
            'label' => $orders->pluck('name')->toArray(),
            'data' => $orders->pluck('total_qty')->toArray()
        ];

        // dd($data);
        $this->orders = json_encode($data);
        // dd($this->orders);


        // produk perhari yang laris
        $orderDay = OrderItem::whereDay('order_items.created_at', Carbon::now()->day)
        ->whereYear('order_items.created_at', Carbon::now()->year)
        ->join('products', 'order_items.product_id', '=', 'products.id')
        ->selectRaw('products.nm_produk as name, SUM(order_items.qty) as total_qty')
        ->groupBy('products.nm_produk')
        ->orderByDesc('total_qty')
        ->limit(10)->get();

        $dataDay = [
            'labelDay' => $orderDay->pluck('name')->toArray(),
            'dataDay' => $orderDay->pluck('total_qty')->toArray()
        ];

        // dd($dataDay);
        $this->orderDay = json_encode($dataDay);


        // produk perhari yang laris
        $orderBest = OrderItem::join('products', 'order_items.product_id', '=', 'products.id')
        ->selectRaw('products.nm_produk as name, SUM(order_items.qty) as total_qty')
        ->groupBy('products.nm_produk')
        ->limit(10)->get();

        $dataBest = [
            'labelBest' => $orderBest->pluck('name')->toArray(),
            'dataBest' => $orderBest->pluck('total_qty')->toArray()
        ];

        // dd($dataBest);
        $this->orderBest = json_encode($dataBest);
        // dd($this->orderBest);


        // pengeluaran dan pemasukan
        $pemasukan = Order::sum('total');
        $pengeluaran = Pengeluaran::sum('jumlah');

        $dataInOut = [
            'pemasukan' => $pemasukan,
            'pengeluaran' => $pengeluaran,
        ];

        // dd($dataInOut);
        $this->dataInOut = json_encode($dataInOut);


    }

    // data pengeluaran & pemasukan update
    public function changeInOut(){
        // pengeluaran dan pemasukan
        $pemasukan = Order::sum('total');
        $pengeluaran = Pengeluaran::sum('jumlah');

        $dataInOut = [
            'pemasukan' => $pemasukan,
            'pengeluaran' => $pengeluaran,
        ];

        // dd($dataInOut);
        $this->dataInOut = json_encode($dataInOut);

        $this->dispatch('phpInOut', data: $this->dataInOut);
    }

    // data produk pertaun update
    public function changeYear(){
         // produk pertahun
         $orderYear = OrderItem::whereYear('order_items.created_at', Carbon::now()->year)
         ->whereYear('order_items.created_at', Carbon::now()->year)
         ->join('products', 'order_items.product_id', '=', 'products.id')
         ->selectRaw('products.nm_produk as name, SUM(order_items.qty) as total_qty')
         ->groupBy('products.nm_produk')
         ->orderByDesc('total_qty')
         ->limit(10)->get();
 
         $dataYear = [
             'labelYear' => $orderYear->pluck('name')->toArray(),
             'dataYear' => $orderYear->pluck('total_qty')->toArray()
         ];
 
         // dd($dataYear);
         $this->orderYear = json_encode($dataYear);

         $this->dispatch('yearWork', data: $this->orderYear);
    }

    // data produk perhari
    public function changeDay(){
        $orderDay = OrderItem::whereDay('order_items.created_at', Carbon::now()->day)
        ->whereYear('order_items.created_at', Carbon::now()->year)
        ->join('products', 'order_items.product_id', '=', 'products.id')
        ->selectRaw('products.nm_produk as name, SUM(order_items.qty) as total_qty')
        ->groupBy('products.nm_produk')
        ->orderByDesc('total_qty')
        ->limit(10)->get();

        $dataDay = [
            'labelDay' => $orderDay->pluck('name')->toArray(),
            'dataDay' => $orderDay->pluck('total_qty')->toArray()
        ];

        // dd($dataDay);
        $this->orderDay = json_encode($dataDay);

        $this->dispatch('dayWork', data: $this->orderDay);

    }

    // data produk perbulan
    public function changeDataMonth(){
        $orders = OrderItem::whereMonth('order_items.created_at', Carbon::now()->month)
        ->whereYear('order_items.created_at', Carbon::now()->year)
        ->join('products', 'order_items.product_id', '=', 'products.id')
        ->selectRaw('products.nm_produk as name, SUM(order_items.qty) as total_qty')
        ->groupBy('products.nm_produk')
        ->orderByDesc('total_qty')
        ->limit(10)->get();
        

        $data = [
            'label' => $orders->pluck('name')->toArray(),
            'data' => $orders->pluck('total_qty')->toArray()
        ];

        // dd($data);
        $this->orders = json_encode($data);
        // dd($this->orders);
        $this->dispatch('berhasil', data: $this->orders);
    }

    // data produk terlaris update
    public function changeBestProduct(){
        // produk perhari yang laris
        $orderBest = OrderItem::join('products', 'order_items.product_id', '=', 'products.id')
        ->selectRaw('products.nm_produk as name, SUM(order_items.qty) as total_qty')
        ->groupBy('products.nm_produk')
        ->limit(10)->get();

        $dataBest = [
            'labelBest' => $orderBest->pluck('name')->toArray(),
            'dataBest' => $orderBest->pluck('total_qty')->toArray()
        ];

        // dd($dataBest);
        $this->orderBest = json_encode($dataBest);

        $this->dispatch('bestProduct', data: $this->orderBest);

    }


    public function render()
    {   
        $year = Carbon::now();
        // $tahun = Carbon::now('year');
        $totalCount = OrderItem::whereYear('created_at', Carbon::now()->year)->SUM('total');

        // pendapatan semua
        $totalPendapatan = Order::sum('total');

        // pengeluaran
        $pengeluaran = Pengeluaran::sum('jumlah');

        $Datapengeluaran = Pengeluaran::paginate(5);

        // dd($tahun);
        return view('livewire.dashboard.chart-dashboard', [
            'orders' => $this->orders,
            'orderDay' => $this->orderDay,
            'orderYear' => $this->orderYear,
            'orderBest' => $this->orderBest,
            'dataInOut' => $this->dataInOut
        ], compact('totalCount', 'year', 'totalPendapatan', 'pengeluaran', 'Datapengeluaran'));
    }
}
