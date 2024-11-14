<?php

use App\Http\Controllers\PenjualanProdukController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ProdukController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\StokGudangController;
use App\Models\StokGudang;

Route::get('/', function () {
    return view('welcome');
});

// Route::get('/dashboard', function () {
//     return view('dashboard');
// })->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});


Route::get('produk', [ProdukController::class, 'index'])->name('produk.index');
Route::get('produk/create', [ProdukController::class, 'create'])->name('produk.create');
Route::post('produk/store', [ProdukController::class, 'store'])->name('produk.store');
Route::get('produk/edit/{id}', [ProdukController::class, 'edit'])->name('produk.edit');
Route::post('produk/update/{id}', [ProdukController::class, 'update'])->name('produk.update');
Route::get('produk/destroy/{id}', [ProdukController::class, 'destroy'])->name('produk.destroy');


Route::resource('penjualan-produk', PenjualanProdukController::class);
Route::resource('stok-gudang', StokGudangController::class);

Route::resource('users', UserController::class);

require __DIR__.'/auth.php';
