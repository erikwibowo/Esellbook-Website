<?php

use App\Http\Controllers\api\AdminController;
use App\Http\Controllers\api\DataController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::post('/admin/login', [AdminController::class, 'login'])->name('api.admin.login');
Route::post('/data/create', [DataController::class, 'create'])->name('api.data.create');
Route::get('/data/show', [DataController::class, 'show'])->name('api.data.show');
Route::get('/item/show', [DataController::class, 'item'])->name('api.data.item');
