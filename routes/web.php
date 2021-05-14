<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\CelebController;
use App\Http\Controllers\MovieController;
use App\Http\Controllers\ReviewController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\WatchlistController;

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

/** Celebs, Movies, Reviews | Index */
Route::get('/celebs', [CelebController::class, 'index'])->name('celebs.index');
Route::get('/movies', [MovieController::class, 'index'])->name('movies.index');
Route::get('/reviews', [ReviewController::class, 'index'])->name('reviews.index');


/** Middleware Admin */
Route::group(['middleware'=>'admin'], function()
{
    /** Celebs */
    Route::get('/celebs/create', [CelebController::class, 'create'])->name('celebs.create');
    Route::post('/celebs', [CelebController::class, 'store'])->name('celebs.store');
    Route::get('/celebs/{celeb}/edit', [CelebController::class, 'edit'])->name('celebs.edit');
    Route::put('/celebs/{celeb}', [CelebController::class, 'update'])->name('celebs.update');
    Route::delete('/celebs/{celeb}', [CelebController::class, 'destroy'])->name('celebs.destroy');

    /** Movies */
    Route::get('/movies/create', [MovieController::class, 'create'])->name('movies.create');
    Route::post('/movies', [MovieController::class, 'store'])->name('movies.store');
    Route::get('/movies/{movie}/edit', [MovieController::class, 'edit'])->name('movies.edit');
    Route::put('/movies/{movie}', [MovieController::class, 'update'])->name('movies.update');
    Route::delete('/movies/{movie}', [MovieController::class, 'destroy'])->name('movies.destroy');
});

/** Middleware Auth */
Route::group(['middleware'=> 'auth'], function()
{
    /** Reviews */
    Route::resource('movies/{movie}/reviews', ReviewController::class)->except(['index', 'show']);

    /** User Profile */
    Route::get('/profile/{user}', [ProfileController::class, 'dashboard'])->name('profile.dashboard');
    Route::get('/profile/{user}/reviews', [ProfileController::class, 'reviews'])->name('profile.reviews');

    /** Watchlist */
    Route::get('/profile/{user}/watchlist', [WatchlistController::class, 'index'])->name('watchlist.index');
    Route::get('/profile/{user}/watchlist/create', [WatchlistController::class, 'create'])->name('watchlist.create');
    Route::post('/profile/{user}/watchlist/{movie}', [WatchlistController::class, 'store'])->name('watchlist.store');
    Route::delete('/profile/{user}/watchlist/{movie}', [WatchlistController::class, 'destroy'])->name('watchlist.destroy');
});

/** Celebs, Movies, Reviews | Show */
Route::get('/celebs/{celeb}', [CelebController::class, 'show'])->name('celebs.show');
Route::get('/movies/{movie}', [MovieController::class, 'show'])->name('movies.show');
Route::get('/movies/{movie}/reviews/{review}', [ReviewController::class, 'show'])->name('reviews.show');
