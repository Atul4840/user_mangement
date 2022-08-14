<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;

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
Route::get('index', [UserController::class, 'index'])->name('user.index');
Route::POST('add', [UserController::class, 'Insert'])->name('insert');
Route::get('fetch', [UserController::class, 'UserFetch'])->name('user.fetch');
Route::get('delete/{id}', [UserController::class, 'destroy'])->name('user.delete');
