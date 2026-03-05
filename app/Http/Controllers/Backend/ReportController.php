<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Pengeluaran;
// use Barryvdh\DomPDF\PDF;
use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;
use Illuminate\Http\Request;

class ReportController extends Controller
{

    // tampilan halaman riwayat & laporan
    public function viewReport(){
        // $orderItems = OrderItem::with('order.user')->latest()->get();
        $orders = Order::with('user')->latest()->get();
        return view('Backend.reports.view-reports', compact('orders'), ['title' => 'viewReport']);
    }

    // tampilan detail riwayat dan laporan
    public function detailReport($id){
        $orders = Order::with(['orderitem.product', 'orderitem.Ukuran.toping', 'orderitem.toping', 'user'])->find($id);
        return view('Backend.reports.detail-reports', compact('orders'), ['title' => 'detail report']);
    }

    // cetak riwayat order tgl
    public function cetakReports(Request $request){
        $search = $request->input('search');

        $orders = Order::with(['orderitem.product', 'orderitem.Ukuran.toping', 'orderitem.toping', 'user'])
        ->when($search, function ($query, $search){
            $query->whereDate('created_at', 'like', '%' . $search . '%');
        })->get();

        $totalOrder = $orders->count();
        $totalPendapatan = $orders->sum('total');
        $tglCetak = Carbon::now();

        return view('Backend.reports.cetak-reports', compact('orders', 'totalOrder', 'totalPendapatan', 'tglCetak', 'search'));

        // $pdf = Pdf::loadView('Backend.reports.cetak-reports', compact('orders', 'search'), ['title' => 'Laporan']);

        // return $pdf->download('laporan' . '.pdf');
    }

    // cetak detail riwayat dan order
    public function detailCetak($id){
        $orders = Order::with(['orderitem.product', 'orderitem.Ukuran.toping', 'orderitem.toping', 'user'])->find($id);

        return view('Backend.reports.detail-cetak', compact('orders'));

        // $pdf = Pdf::loadView('Backend.reports.detail-cetak', compact('orders'));
        // return $pdf->download('cetak-detail' . '.pdf');

    }


    // halaman untuk pengeluaran
    public function viewPengeluaran(){
        return view('Backend.pengeluaran.pengeluaran-main', ['title' => 'viewPengeluaran']);
    }

    // edit pengeluaran
    public function editPengeluaran($id){
        $pengeluaran = Pengeluaran::findOrFail($id);
        return view('Backend.pengeluaran.pengeluaran-edit', compact('pengeluaran'), ['title' => 'editPengeluaran']);
    }

    // cetak pengeluaran
    public function cetakPengeluaran(Request $request){
        $search = $request->input('search');
        $pengeluaran = Pengeluaran::where('tanggal', 'like', '%'.$search.'%')->get();
        $orders = Order::all();
        

        $tglCetak = Carbon::now();
        
        // pengeluaran sesuai tgl
        $totalPengeluaran = $pengeluaran->sum('jumlah');

        $saldo = $orders->sum('total') - $pengeluaran->sum('jumlah');


        return view('Backend.pengeluaran.cetak-pengeluaran', compact('pengeluaran', 'orders', 'search', 'tglCetak', 'saldo'));

    }


}
