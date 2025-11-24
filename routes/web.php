<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ParentController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

// 1. Halaman Depan (Root) adalah Form Login
Route::get('/', [ParentController::class, 'showLoginForm'])->name('login');
Route::post('/login', [ParentController::class, 'login'])->name('parent.login.submit');

// 2. Halaman Dashboard (Hanya bisa diakses jika sudah login)
Route::middleware(['auth'])->group(function () {
    Route::get('/dashboard', [ParentController::class, 'dashboard'])->name('parent.dashboard');
    Route::post('/logout', [ParentController::class, 'logout'])->name('parent.logout');
});