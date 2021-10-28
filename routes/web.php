<?php

use Illuminate\Support\Facades\Route;
use Modules\Role\Http\Controllers\RoleController;
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
});
