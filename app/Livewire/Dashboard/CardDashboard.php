<?php

namespace App\Livewire\Dashboard;

use App\Models\Kategori;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Pengeluaran;
use App\Models\Product;
use Carbon\Carbon;
use GuzzleHttp\Handler\Proxy;
use Livewire\Component;

class CardDashboard extends Component
{
    protected $listeners = ['MonthProduct' => 'soldDay'];
    
    public function soldDay(){
        $this->render();
    }

    public function render()
    {   
        // penjualan hari ini
        $soldDay = OrderItem::whereDate('created_at', Carbon::today())->SUM('qty');
        $incomeDay = OrderItem::whereDate('created_at', Carbon::today())->SUM('total');
        // dd($incomeDay);


        // total jual bulanan
        $totalMonth = OrderItem::whereMonth('created_at', Carbon::now()->month)
        ->whereYear('created_at', Carbon::now()->year)
        ->SUM('qty');
        $incomeMonth = OrderItem::whereMonth('created_at', Carbon::now()->month)
        ->whereYear('created_at', Carbon::now()->year)
        ->SUM('total');
        // dd($incomeMonth);

        // penjualan pertahun
        $totalYear = OrderItem::whereYear('created_at', Carbon::now()->year)
        ->whereYear('created_at', Carbon::now()->year)
        ->SUM('qty');
        $incomeYear = OrderItem::whereYear('created_at', Carbon::now()->year)
        ->whereYear('created_at', Carbon::now()->year)
        ->SUM('total');
        // dd($incomeYear);

        // total Produk
        $totalProduct = Product::count();

        // kategori
        $categories = Kategori::latest()->get();

        $pemasukan = Order::sum('total');

        $pengeluaran = Pengeluaran::sum('jumlah');

        $saldoAkhir = $pemasukan - $pengeluaran;


        return view('livewire.dashboard.card-dashboard', compact(
        'soldDay', 'incomeDay',
        'totalMonth', 'incomeMonth', 
        'totalYear', 'incomeYear',
         'totalProduct', 'categories',
         'pemasukan', 'pengeluaran', 'saldoAkhir'
        ));
    }
}
