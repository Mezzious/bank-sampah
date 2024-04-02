<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\LurahController;
use App\Http\Controllers\SesiController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\SuperAdminController;
use App\Http\Controllers\UserController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('app');
});

Route::middleware(['guest'])->group(function () {
    Route::get('/index', [SesiController::class, 'index'])->name('index');
    Route::post('/index', [SesiController::class, 'login']);
});
// Super Admin Route //
Route::get('/dashboard', [SuperAdminController::class, 'index'])->name('dashboard');

Route::middleware(['auth'])->group(function () {
    Route::get('/superAdmin', [SuperAdminController::class, 'index'])->name('dashboard');
    Route::get('/admin', [AdminController::class, 'index'])->name('dashboard');
    Route::get('/user', [UserController::class, 'index'])->name('dashboard');
    Route::get('/logout', [SesiController::class, 'logout'])->name('logout');
});

Route::get('/data_user', [SuperAdminController::class, 'data_user' ])->name('data_user');

Route::get('/data_sampah', [SuperAdminController::class, 'data_sampah'])->name('data_sampah');

Route::get('/data_admin', [SuperAdminController::class, 'data_admin'])->name('data_admin');

Route::get('/data_nasabah', [SuperAdminController::class, 'data_nasabah'])->name('data_nasabah');

Route::get('/transaksi_beli', [SuperAdminController::class, 'transaksi_beli'])->name('transaksi_beli');

Route::get('/transaksi_jual', [SuperAdminController::class, 'transaksi_jual'])->name('transaksi_jual');

Route::get('/laporan_jual', [SuperAdminController::class, 'laporan_jual'])->name('laporan_jual');

Route::get('/laporan_beli', [SuperAdminController::class, 'laporan_beli'])->name('laporan_beli');

Route::get('/tambah_sampah', [SuperAdminController::class, 'tambah_sampah']);

Route::get('/cari_sampah', [SuperAdminController::class, 'cari_sampah']);

Route::get('tambah_user', [SuperAdminController::class, 'tambah_user' ])->name('tambah_user');

Route::get('edit_user', [SuperAdminController::class, 'edit_user' ])->name('edit_user');

Route::get('ganti_password', [SuperAdminController::class, 'ganti_password' ])->name('ganti_password');

Route::get('tambah_nasabah', [SuperAdminController::class, 'tambah_nasabah' ])->name('tambah_nasabah');

Route::get('edit_nasabah', [SuperAdminController::class, 'edit_nasabah' ])->name('edit_nasabah');

Route::get('/tambah_sampah', [SuperAdminController::class,'tambah_sampah'])->name('tambah_sampah');

Route::get('/edit_sampah', [SuperAdminController::class,'edit_sampah'])->name('edit_sampah');

Route::get('/tambah_transaksi_jual', [SuperAdminController::class,'tambah_transaksi_jual'])->name('tambah_transaksi_jual');

Route::get('/edit_transaksi_jual', [SuperAdminController::class,'edit_transaksi_jual'])->name('edit_transaksi_jual');

Route::get('/tambah_transaksi_beli', [SuperAdminController::class,'tambah_transaksi_beli'])->name('tambah_transaksi_beli');

Route::get('/edit_transaksi_beli', [SuperAdminController::class,'edit_transaksi_beli'])->name('edit_transaksi_beli');

// User Route //
Route::get('/data_nasabah_user', [UserController::class, 'data_nasabah_user' ])->name('data_nasabah_user');

Route::get('/data_sampah_user', [UserController::class, 'data_sampah_user' ])->name('data_sampah_user');

Route::get('ganti_password_user', [UserController::class, 'ganti_password_user' ])->name('ganti_password_user');

Route::get('/laporan_jual_user', [UserController::class, 'laporan_jual_user' ])->name('laporan_jual_user');

Route::get('/laporan_beli_user', [UserController::class, 'laporan_beli_user' ])->name('laporan_beli_user');

Route::get('/transaksi_beli_user', [UserController::class, 'transaksi_beli_user' ])->name('transaksi_beli_user');

Route::get('/transaksi_jual_user', [UserController::class, 'transaksi_jual_user' ])->name('transaksi_jual_user');





