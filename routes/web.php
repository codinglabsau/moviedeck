<?php

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

Route::get('/', [\App\Http\Controllers\HomeController::class, 'index'])->name('main');

Route::get('/movies', [\App\Http\Controllers\MovieController::class, 'index'])->name('movies');
Route::get('/movies/create', [\App\Http\Controllers\MovieController::class, 'create']);
Route::get('/movies/{movie}', [\App\Http\Controllers\MovieController::class, 'show'])->name('movies.show');
Route::get('/movies/{movie}/edit', [\App\Http\Controllers\MovieController::class, 'show']);
Route::post('/movies', [\App\Http\Controllers\MovieController::class, 'store']);
Route::put('/movies/{movie}', [\App\Http\Controllers\MovieController::class, 'update']);
Route::delete('/movies/{movie}', [\App\Http\Controllers\MovieController::class, 'destroy']);
Auth::routes();

Route::get('/home', [\App\Http\Controllers\HomeController::class, 'index'])->name('home');

