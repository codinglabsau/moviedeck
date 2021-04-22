<?php

use Illuminate\Support\Facades\Auth;
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
Auth::routes();

Route::get('/', [\App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::group(['middleware'=>'admin'], function()
{
    Route::get('/celebs/create', [\App\Http\Controllers\CelebController::class, 'create'])->name('celebs.create');
    Route::post('/celebs', [\App\Http\Controllers\CelebController::class, 'store'])->name('celebs.store');
    Route::get('/celebs/{celeb}/edit', [\App\Http\Controllers\CelebController::class, 'edit'])->name('celebs.edit');
    Route::put('/celebs/{celeb}', [\App\Http\Controllers\CelebController::class, 'update'])->name('celebs.update');
    Route::delete('/celebs/{celeb}', [\App\Http\Controllers\CelebController::class, 'destroy'])->name('celebs.destroy');

    Route::get('/movies/create', [\App\Http\Controllers\MovieController::class, 'create']);
    Route::post('/movies', [\App\Http\Controllers\MovieController::class, 'store']);
    Route::get('/movies/{movie}/edit', [\App\Http\Controllers\MovieController::class, 'edit']);
    Route::put('/movies/{movie}', [\App\Http\Controllers\MovieController::class, 'update']);
    Route::delete('/movies/{movie}', [\App\Http\Controllers\MovieController::class, 'destroy']);
});

Route::get('/celebs', [\App\Http\Controllers\CelebController::class, 'index'])->name('celebs.index');
Route::get('/celebs/{celeb}', [\App\Http\Controllers\CelebController::class, 'show'])->name('celebs.show');

Route::get('/movies', [\App\Http\Controllers\MovieController::class, 'index'])->name('movies.index');
Route::get('/movies/{movie}', [\App\Http\Controllers\MovieController::class, 'show'])->name('movies.show');

