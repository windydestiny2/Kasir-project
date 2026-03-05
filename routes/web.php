<?php

use App\Http\Controllers\Backend\KategoriController;
use App\Http\Controllers\Backend\LoginController;
use App\Http\Controllers\Backend\OrderController;
use App\Http\Controllers\Backend\ProductController;
use App\Http\Controllers\Backend\ProfilController;
use App\Http\Controllers\Backend\ReportController;
use App\Http\Controllers\Backend\TopingController;
use App\Http\Controllers\Backend\UkuranController;
use App\Http\Controllers\Backend\UserController;
use App\Livewire\Order\OrderPesanan;
use App\Livewire\Ukuran\TambahUkuran;
use App\Models\Product;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::middleware('guest')->group(function(){
    Route::get('/', [LoginController::class, 'viewLogin'])->name('login');
    Route::post('/authenticate', [LoginController::class, 'authenticated'])->name('authlogin');
});

Route::middleware('auth')->group(function(){
    // logout & dashboard
    Route::get('/logout', [LoginController::class, 'logout'])->name('logout');
    Route::get('/dashboard', [LoginController::class, 'viewDashboard'])->name('dashboard');

    // kategori
    Route::get('/viewKategori', [KategoriController::class, 'viewKategori'])->name('view.kategori');
    Route::get('/editKategori/{id}', [KategoriController::class, 'editKategori'])->name('edit.kategori');

    // product
    Route::get('/product', [ProductController::class, 'viewProduct'])->name('view.product');
    Route::get('/product/edit/{id}', [ProductController::class, 'editProduct'])->name('edit.product');
    Route::get('/order', [OrderController::class, 'viewOrder'])->name('view.order');

    // toping
    Route::get('/toping', [TopingController::class, 'viewToping'])->name('view.toping');
    Route::get('/toping/edit/{id}', [TopingController::class, 'editToping'])->name('edit.toping');


    // Ukuran
    Route::get('/Ukuran', [UkuranController::class, 'viewUkuran'])->name('view.Ukuran');
    Route::get('/edit/Ukuran/{id}', [UkuranController::class, 'editUkuran'])->name('edit.Ukuran');

    Route::get('/toping/ajax/{toping_id}', [OrderPesanan::class, 'GetToping']);

    // tampilan riwayat & laporan , detail pesanan
    Route::get('/viewReport', [ReportController::class, 'viewReport'])->name('view.report');
    Route::get('/detailReport/{id}', [ReportController::class, 'detailReport'])->name('detail.report');

    // cetak report sesuai tgl
    Route::get('/cetakReports', [ReportController::class, 'cetakReports'])->name('cetak.reports');

    // cetak detail pesanan
    Route::get('/detailCetak/{id}', [ReportController::class, 'detailCetak'])->name('detail.cetak');

    // tampilan profile
    Route::get('/profil/{id}', [ProfilController::class, 'viewProfil'])->name('view.profil');

    // kelola user/admin
    Route::get('viewAdmin', [UserController::class, 'viewUser'])->name('view.user');
    Route::get('editAdmin/{id}', [UserController::class, 'editUser'])->name('edit.user');

    // pengeluaran
    Route::get('/viewPengeluaran', [ReportController::class, 'viewPengeluaran'])->name('view.pengeluaran');
    Route::get('/editPengeluaran/{id}', [ReportController::class, 'editPengeluaran'])->name('edit.Pengeluaran');

    // cetak pengeluaran
    Route::get('/cetakPengeluaran', [ReportController::class, 'cetakPengeluaran'])->name('cetak.pengeluaran');


});


// Route::get('/product', function(){
//     return view('Backend.Product.product-main', ['title' => 'Product'])->name('product-main');
// });
Route::get('/belajar', function(){
    return view('laravel-pemula');
});


