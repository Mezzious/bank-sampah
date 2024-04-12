<?php

use App\Http\Controllers\LandingPageController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\SesiController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\SuperAdminController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\NasabahController;

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

// Route::get('/', function () {
//     return view('auth.login');
// });

Route::get('/home', [LandingPageController::class, 'home' ])->name('home');


Route::middleware(['guest'])->group(function () {
    Route::get('/index', [SesiController::class, 'index'])->name('index');
    Route::post('/index', [SesiController::class, 'login']);
});

//Superadmin
Route::group(['middleware' => ['auth', 'admin:super-admin']], function () {

Route::get('/superadmin', [SuperAdminController::class, 'index'])->name('dashboard');

Route::get('/dashboard', function () {
})->name('dashboard');

Route::get('/data_user', [SuperAdminController::class, 'data_user' ])->name('data_user');

Route::get('/data_sampah', [SuperAdminController::class, 'data_sampah'])->name('data_sampah');

Route::get('/data_nasabah', [SuperAdminController::class, 'data_nasabah'])->name('data_nasabah');

Route::get('/transaksi_beli', [SuperAdminController::class, 'transaksi_beli'])->name('transaksi_beli');

Route::get('/transaksi_jual', [SuperAdminController::class, 'transaksi_jual'])->name('transaksi_jual');

Route::get('/laporan_jual', [SuperAdminController::class, 'laporan_jual'])->name('laporan_jual');

Route::get('/laporan_beli', [SuperAdminController::class, 'laporan_beli'])->name('laporan_beli');

Route::get('/tambah_sampah', [SuperAdminController::class, 'tambah_sampah']);

Route::get('/tambah_user', [SuperAdminController::class, 'tambah_user' ])->name('tambah_user');

Route::post('/tambah_user', [SuperAdminController::class, 'store_user' ])->name('store_user');

Route::get('/edit_user', [SuperAdminController::class, 'edit_user' ])->name('edit_user');

Route::put('/edit_user', [SuperAdminController::class, 'update_user' ])->name('update_user');

Route::get('/data_user/{id}/destroy_user', [SuperAdminController::class, 'destroy' ])->name('destroy_user');

Route::get('/ganti_password', [SuperAdminController::class, 'ganti_password' ])->name('ganti_password');

Route::get('/tambah_nasabah', [SuperAdminController::class, 'tambah_nasabah' ])->name('tambah_nasabah');

Route::get('/edit_nasabah', [SuperAdminController::class, 'edit_nasabah' ])->name('edit_nasabah');

Route::get('/tambah_sampah', [SuperAdminController::class,'tambah_sampah'])->name('tambah_sampah');

Route::get('/edit_sampah', [SuperAdminController::class,'edit_sampah'])->name('edit_sampah');

Route::get('/tambah_transaksi_jual', [SuperAdminController::class,'tambah_transaksi_jual'])->name('tambah_transaksi_jual');

Route::get('/edit_transaksi_jual', [SuperAdminController::class,'edit_transaksi_jual'])->name('edit_transaksi_jual');

Route::get('/tambah_transaksi_beli', [SuperAdminController::class,'tambah_transaksi_beli'])->name('tambah_transaksi_beli');

Route::get('/edit_transaksi_beli', [SuperAdminController::class,'edit_transaksi_beli'])->name('edit_transaksi_beli');

Route::get('/cetak_laporan_jual', [SuperAdminController::class,'cetak_laporan_jual'])->name('cetak_laporan_jual');

Route::get('/cetak_laporan_beli', [SuperAdminController::class,'cetak_laporan_beli'])->name('cetak_laporan_beli');
});

//Admin
Route::group(['middleware' => ['auth', 'admin:admin']], function () {

Route::get('/admin', [AdminController::class, 'index'])->name('dashboard');

Route::get('/dashboard_admin', [AdminController::class, 'index'])->name('dashboard_admin');

Route::get('/data_nasabah_admin', [AdminController::class, 'data_nasabah_admin'])->name('data_nasabah_admin');

Route::get('/data_sampah_admin', [AdminController::class, 'data_sampah_admin'])->name('data_sampah_admin');

Route::get('/data_user_admin', [AdminController::class, 'data_user_admin'])->name('data_user_admin');

Route::get('/transaksi_jual_admin', [AdminController::class, 'transaksi_jual_admin'])->name('transaksi_jual_admin');

Route::get('/transaksi_beli_admin', [AdminController::class, 'transaksi_beli_admin'])->name('transaksi_beli_admin');

Route::get('/laporan_jual_admin', [AdminController::class, 'laporan_jual_admin'])->name('laporan_jual_admin');

Route::get('/laporan_beli_admin', [AdminController::class, 'laporan_beli_admin'])->name('laporan_beli_admin');

Route::get('/ganti_password_admin', [AdminController::class, 'ganti_password_admin'])->name('ganti_password_admin');
});

//User
Route::group(['middleware' => ['auth', 'admin:user']], function () {
Route::get('/user', [UserController::class, 'index'])->name('dashboard');

Route::get('/dashboard_user', [UserController::class, 'index'])->name('dashboard_user');

Route::get('/transaksi_jual_user', [UserController::class, 'transaksi_jual_user'])->name('transaksi_jual_user');

Route::get('/tambah_transaksi_jual_user', [UserController::class, 'tambah_transaksi_jual_user'])->name('tambah_transaksi_jual_user');

Route::get('/edit_transaksi_jual_user', [UserController::class, 'edit_transaksi_jual_user'])->name('edit_transaksi_jual_user');

Route::get('/laporan_jual_user', [UserController::class, 'laporan_jual_user'])->name('laporan_jual_user');

Route::get('/ganti_password_user', [UserController::class, 'ganti_password_user'])->name('ganti_password_user');
});

Route::get('/logout', [SesiController::class, 'logout'])->name('logout');


// Nasabah Route //

Route::get('/dashboard_nasabah', [NasabahController::class, 'index'])->name('dashboard_nasabah');

Route::get('/transaksi_beli_nasabah', [NasabahController::class, 'transaksi_beli_nasabah'])->name('transaksi_beli_nasabah');

Route::get('/tambah_transaksi_beli_nasabah', [NasabahController::class, 'tambah_transaksi_beli_nasabah'])->name('tambah_transaksi_beli_nasabah');

Route::get('/edit_transaksi_beli_nasabah', [NasabahController::class, 'edit_transaksi_beli_nasabah'])->name('edit_transaksi_beli_nasabah');

Route::get('/laporan_beli_nasabah', [NasabahController::class, 'laporan_beli_nasabah'])->name('laporan_beli_nasabah');

Route::get('/ganti_password_nasabah', [NasabahController::class, 'ganti_password_nasabah'])->name('ganti_password_nasabah');
