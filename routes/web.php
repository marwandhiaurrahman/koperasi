<?php

use Illuminate\Support\Facades\Route;
use Modules\Pinjaman\Http\Controllers\PinjamanController;
use Modules\Role\Http\Controllers\RoleController;
use Modules\Simpanan\Http\Controllers\SimpananController;
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

Route::get('/dashboard', function() {
    return view('dashboard');
})->name('dashboard')->middleware('auth');

Route::prefix('admin')->middleware('auth')->group(function () {
    Route::resource('role', RoleController::class);
    Route::resource('user', UserController::class);
    Route::resource('simpanan', SimpananController::class);
    Route::resource('pinjaman', PinjamanController::class);
    Route::resource('transaksi', TransaksiController::class);
});
