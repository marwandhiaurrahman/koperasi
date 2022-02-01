<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use Modules\Anggota\Http\Controllers\AnggotaController;
use Modules\Pinjaman\Http\Controllers\PinjamanAnggotaController;
use Modules\Pinjaman\Http\Controllers\PinjamanController;
use Modules\Role\Http\Controllers\PermissionController;
use Modules\Role\Http\Controllers\RoleController;
use Modules\Simpanan\Http\Controllers\SimpananAnggotaController;
use Modules\Simpanan\Http\Controllers\SimpananController;
use Modules\Transaksi\Http\Controllers\TransaksiAnggotaController;
use Modules\Transaksi\Http\Controllers\TransaksiController;
use Modules\User\Http\Controllers\UserController;

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

Auth::routes();

Route::get('/dashboard', function () {
    return view('dashboard');
})->name('dashboard')->middleware('auth');

Route::get('/profil', [UserController::class, 'profile'])->name('profil')->middleware('auth');
Route::patch('/profil',  [UserController::class, 'profile_update'])->name('profil.update')->middleware('auth');

Route::prefix('admin')->name('admin.')->middleware('auth')->group(function () {
    Route::resource('role', RoleController::class, ['only' => ['index', 'store', 'edit', 'destroy']]);
    Route::resource('permission', PermissionController::class, ['only' => ['index','store', 'edit', 'destroy']]);
    Route::resource('user', UserController::class);
    Route::resource('anggota', AnggotaController::class);
    Route::resource('simpanan', SimpananController::class);
    Route::resource('pinjaman', PinjamanController::class);
    Route::resource('transaksi', TransaksiController::class);
});

Route::prefix('anggota')->name('anggota.')->middleware('auth')->group(function () {
    Route::resource('simpanan', SimpananAnggotaController::class);
    Route::resource('pinjaman', PinjamanAnggotaController::class);
    Route::resource('transaksi', TransaksiAnggotaController::class);
});
