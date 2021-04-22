<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\CelebController;
use App\Http\Controllers\MovieController;

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
/** Auth */
Auth::routes();

/** Home */
Route::get('/', [HomeController::class, 'index'])->name('home');

/** Celebs */
Route::get('/celebs', [CelebController::class, 'index'])->name('celebs.index');
Route::get('/celebs/{celeb}', [CelebController::class, 'show'])->name('celebs.show');

/** Movies */
Route::get('/movies', [MovieController::class, 'index'])->name('movies.index');
Route::get('/movies/{movie}', [MovieController::class, 'show'])->name('movies.show');

/** Middleware Admin */
Route::group(['middleware'=>'admin'], function()
{
    /** Movies */
    Route::get('/movies/create', [MovieController::class, 'create'])->name('movies.create');
    Route::post('/movies', [MovieController::class, 'store'])->name('movies.store');
    Route::get('/movies/{movie}/edit', [MovieController::class, 'edit'])->name('movies.edit');
    Route::put('/movies/{movie}', [MovieController::class, 'update']);
    Route::delete('/movies/{movie}', [MovieController::class, 'destroy']);

    /** Celebs */
    Route::get('/celebs/create', [CelebController::class, 'create'])->name('celebs.create');
    Route::post('/celebs', [CelebController::class, 'store'])->name('celebs.store');
    Route::get('/celebs/{celeb}/edit', [CelebController::class, 'edit'])->name('celebs.edit');
    Route::put('/celebs/{celeb}', [CelebController::class, 'update']);
    Route::delete('/celebs/{celeb}', [CelebController::class, 'destroy']);
});

