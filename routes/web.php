<?php

use Illuminate\Support\Facades\Route;
use RealRashid\SweetAlert\Facades\Alert;
use Illuminate\Http\Request;


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
    
    return view('welcome');
});

// Admin/Petugas
Route::prefix('admin')
    ->middleware(['auth', 'admin'])
    ->group(function() {
        Route::get('/', 'DashboardController@index')->name('dashboard');

        Route::resource('pengaduans', 'PengaduanController');

        Route::resource('tanggapan', 'TanggapanController');

        Route::get('masyarakat', 'AdminController@masyarakat');
        Route::resource('petugas', 'PetugasController');

        Route::get('laporan', 'AdminController@laporan');
        Route::get('laporan/cetak', 'AdminController@cetak');
        Route::get('pengaduan/cetak/{id}', 'AdminController@pdf');
});

// Masyarakat
Route::prefix('user')
    ->middleware(['auth', 'MasyarakatMiddleware'])
    ->group(function() {
				Route::get('/', 'MasyarakatController@index')->name('masyarakat-dashboard');
                Route::resource('pengaduan', 'MasyarakatController');
                Route::get('pengaduan', 'MasyarakatController@lihat');
});

use App\Http\Controllers\AdminLaporanController;

// Rute untuk halaman Tamu
Route::get('/admin/laporan/tamu', [AdminLaporanController::class, 'tamu'])->name('admin.laporan.tamu');

use App\Http\Controllers\Auth\UsernameVerificationPromptController;

Route::get('/verify-username', [UsernameVerificationPromptController::class, '__invoke'])
    ->middleware('auth')
    ->name('verification.notice');

require __DIR__.'/auth.php';