<?php

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\EmployeeController;
use App\Http\Controllers\PermissionController;
use App\Http\Controllers\RolesController;
use App\Http\Controllers\TestController;
use App\Http\Controllers\UsersController;
use App\Jobs\TimeInJob;
use Illuminate\Foundation\Application;
use Illuminate\Http\Request;
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
 Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard.index');
});

Route::middleware('auth')->group(function () {
 Route::resource('/users', UsersController::class)->only(['index', 'create', 'store', 'edit', 'update', 'destroy']);

 Route::resource('/employees', EmployeeController::class)->only(['index', 'create', 'store', 'edit', 'update', 'destroy']);

 Route::get('/roles', [RolesController::class, 'index'])->name('roles.index');
 Route::get('/permissions', [PermissionController::class, 'index'])->name('permissions.index');

 Route::post('/time-in', function (Request $request) {
  TimeInJob::dispatch($request)->delay(3);
 })->name('timein');
});

Route::get('/test', [TestController::class, 'index'])->name('test.index');

require __DIR__.'/auth.php';
