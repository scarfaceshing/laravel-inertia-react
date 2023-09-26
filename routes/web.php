<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\UserController;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

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
    return Inertia::render('Auth/Login');
});

Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index']);
});

Route::middleware('auth')->group(function () {
    Route::get('/user-management', [UserController::class, 'index'])->name('user-management.index');
    Route::get('/user-management/create', [UserController::class, 'create'])->name('user-management.create');
    Route::post('/user-management/store', [UserController::class, 'store'])->name('user-management.store');
    Route::get('/user-management/{user}/edit', [UserController::class, 'edit'])->name('user-management.edit');
    Route::put('/user-management/{user}', [UserController::class, 'update'])->name('user-management.update');
    Route::delete('/user-management/{user}/destroy', [UserController::class, 'destroy'])->name('user-management.destroy');
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
