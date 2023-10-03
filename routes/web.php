<?php

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\PermissionController;
use App\Http\Controllers\RolesController;
use App\Http\Controllers\UsersController;
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
 Route::resource('/users', UsersController::class)->only(['index', 'create', 'store', 'edit', 'update', 'destroy']);

 Route::get('/roles', [RolesController::class, 'index'])->name('roles.index');
 Route::get('/permissions', [PermissionController::class, 'index'])->name('permissions.index');
});

require __DIR__.'/auth.php';
