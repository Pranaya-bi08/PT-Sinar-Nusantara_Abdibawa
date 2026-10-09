<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\BarangController;
use App\Http\Controllers\KategoriController;
use App\Http\Controllers\GudangController;
use App\Http\Controllers\PelangganController;
use App\Http\Controllers\PenjualanController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\TransaksiBarangMasukController;
use App\Http\Controllers\TransferBarangController;
use App\Http\Controllers\LaporanController;

Route::get('/', function (){
    return view('login');
});

Route::get('/login', [LoginController::class, 'showLogin'])->name('login');
Route::post('/actionlogin', [LoginController::class, 'actionLogin'])->name('actionLogin');
Route::get('/logout', [LoginController::class, 'actionLogout'])->name('actionLogout');


Route::middleware('auth')->group(function(){

Route::get('/dashboard', [DashboardController::class,'index'])->name('dashboard');

Route::get('/barang', [BarangController::class,'index'])->name('barang.index');
Route::get('/barang/create', [BarangController::class,'create'])->name('barang.create');
Route::post('/barang/simpan', [BarangController::class,'store'])->name('barang.store');  
Route::get('/kategori', [KategoriController::class,'index'])->name('kategori.index');

Route::get('/gudang', [GudangController::class,'index'])->name('gudang.index');
Route::get('/gudang/create', [GudangController::class,'create'])->name('gudang.create');
Route::post('/gudang/simpan', [GudangController::class,'store'])->name('gudang.store');

Route::get('/penjualan', [PenjualanController::class,'index'])->name('penjualan.index');
Route::get('/penjualan/create', [PenjualanController::class,'create'])->name('penjualan.create');
Route::get('/pembatalan-transaksi', [PenjualanController::class, 'cancellationIndex'])
    ->name('penjualan.cancellation.index');
Route::post('/penjualan/{penjualan}/cancel', [PenjualanController::class, 'cancel'])
    ->name('penjualan.cancel');
Route::get('/laporan', [LaporanController::class, 'index'])->name('laporan.index');



Route::get('/pelanggan', [PelangganController::class,'index'])->name('pelanggan.index');
Route::get('/pelanggan/create', [PelangganController::class,'create'])->name('pelanggan.create');









    // Barang masuk
    Route::get('/barang_masuk', [
        TransaksiBarangMasukController::class, 'index'
    ])->name('barang_masuk.index');

    Route::get('/barang_masuk/tambah', [
        TransaksiBarangMasukController::class, 'create'
    ])->name('barang_masuk.create');

    Route::post('/barang_masuk', [
        TransaksiBarangMasukController::class, 'store'
    ])->name('barang_masuk.store');

    // Transfer antar gudang
    Route::get('/transfer', [
        TransferBarangController::class, 'index'
    ])->name('transfer.index');

    Route::get('/transfer/tambah', [
        TransferBarangController::class, 'create'
    ])->name('transfer.create');

    Route::post('/transfer', [
        TransferBarangController::class, 'store'
    ])->name('transfer.store');
});
