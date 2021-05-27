<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\DataController;
use App\Http\Controllers\ItemController;
use App\Http\Controllers\MenuController;
use Illuminate\Support\Facades\Route;

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
    return view('admin/login', ['title' => "Login | " . config('variable.webname')]);
});

Route::get('admin/login', function () {
    return view('admin/login', ['title' => "Login | " . config('variable.webname')]);
})->name('admin.login');
Route::post('admin/auth', [AdminController::class, 'auth'])->name('admin.auth');
Route::get('admin/logout', [AdminController::class, 'logout'])->name('admin.logout');


Route::get('data/print', [DataController::class, 'print'])->name('data.print');

Route::group(['prefix' => 'admin',  'middleware' => 'adminauth'], function () {
    Route::get('/', function () {
        return view('admin/dashboard', ['title' => "Dashboard"]);
    })->name('admin.index');
    Route::get('dashboard', function () {
        return view('admin/dashboard', ['title' => "Dashboard"]);
    })->name('admin.dashboard');
    //Admin
    Route::get('admin', [AdminController::class, 'index'])->name('admin.admin.index');
    Route::post('admin/create', [AdminController::class, 'create'])->name('admin.admin.create');
    Route::put('admin/update', [AdminController::class, 'update'])->name('admin.admin.update');
    Route::delete('admin/delete', [AdminController::class, 'delete'])->name('admin.admin.delete');
    Route::post('admin/data', [AdminController::class, 'data'])->name('admin.admin.data');
    //Menu
    Route::get('menu', [MenuController::class, 'index'])->name('admin.menu.index');
    Route::post('menu/create', [MenuController::class, 'create'])->name('admin.menu.create');
    Route::put('menu/update', [MenuController::class, 'update'])->name('admin.menu.update');
    Route::delete('menu/delete', [MenuController::class, 'delete'])->name('admin.menu.delete');
    Route::post('menu/data', [MenuController::class, 'data'])->name('admin.menu.data');
    //Data
    Route::get('data', [DataController::class, 'index'])->name('admin.data.index');
    Route::get('data/print', [DataController::class, 'print'])->name('admin.data.print');
    Route::delete('data/delete', [DataController::class, 'delete'])->name('admin.data.delete');
    //Item
    Route::get('item', [ItemController::class, 'index'])->name('admin.item.index');
    Route::post('item/create', [ItemController::class, 'create'])->name('admin.item.create');
    Route::put('item/update', [ItemController::class, 'update'])->name('admin.item.update');
    Route::delete('item/delete', [ItemController::class, 'delete'])->name('admin.item.delete');
    Route::post('item/data', [ItemController::class, 'data'])->name('admin.item.data');
});
