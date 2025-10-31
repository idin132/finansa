<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TransaksiController;
use App\Http\Controllers\KategoriController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\LandingPageController;
use App\Http\Controllers\CalendarController;

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

Route::get('/login', function () {
    return view('auth');
});

Route::get('/dashboard', function () {
    return view('dashboard');
});

Route::get('/', function () {
    return view('landing');
});

// Resource
Route::resource('landing', LandingPageController::class);
route::resource('calendar', CalendarController::class);
Route::get('/calendar/events', [CalendarController::class, 'getEvents'])->name('calendar.get');
Route::put('/calendar/events/{event}', [CalendarController::class, 'update'])->name('calendar.update');
Route::delete('/calendar/events/{event}', [CalendarController::class, 'destroy'])->name('calendar.destroy');

// Resource
Route::middleware('auth')->group(function () {
    Route::resource('dashboard', DashboardController::class);
    Route::resource('/kategori', KategoriController::class);
    Route::resource('/transaksi', TransaksiController::class);
    Route::get('/laporan', [TransaksiController::class, 'exportPdf'])->name('transaksi.exportPdf');
});

// Authentication Routes
Route::get('/auth', [AuthController::class, 'index'])->name('login');
Route::post('/register', [AuthController::class, 'register'])->name('register');
Route::post('/actionlogin', [AuthController::class, 'login'])->name('actionlogin');
Route::post('/logout', [AuthController::class, 'logout'])->name('actionlogout');

