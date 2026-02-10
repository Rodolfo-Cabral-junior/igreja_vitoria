<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;

Route::get('/', function () {
    if (!session('user')) {
        return redirect('/login');
    }
    return redirect('/dashboard');
})->name('home')->middleware('auth');

Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login'])->name('login.post');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// Dashboard routes (protected)
Route::get('/dashboard', [AuthController::class, 'dashboard'])->name('dashboard')->middleware('auth');

// Admin routes (protected by admin middleware)
Route::prefix('admin')->name('admin.')->middleware('auth.admin')->group(function () {
    Route::get('/', [DashboardController::class, 'index'])->name('dashboard');
    Route::get('/complete', function () {
        return view('admin.dashboard-complete');
    })->name('dashboard.complete');

    // User CRUD routes
    Route::prefix('users')->name('users.')->group(function () {
        Route::get('/', [DashboardController::class, 'index'])->name('index');
        Route::get('/create', [DashboardController::class, 'create'])->name('create');
        Route::post('/', [DashboardController::class, 'store'])->name('store');
        Route::get('/{user}', [DashboardController::class, 'show'])->name('show');
        Route::get('/{user}/edit', [DashboardController::class, 'edit'])->name('edit');
        Route::put('/{user}', [DashboardController::class, 'update'])->name('update');
        Route::delete('/{user}', [DashboardController::class, 'destroy'])->name('destroy');
    });
});
//teste
