<?php


use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\CelebController;
use App\Http\Controllers\MovieController;
use App\Http\Controllers\ReviewController;

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

/** Celebs, Movies, Reviews */
Route::get('/celebs', [CelebController::class, 'index'])->name('celebs.index');
Route::get('/movies', [MovieController::class, 'index'])->name('movies.index');
Route::get('/reviews', [ReviewController::class, 'index'])->name('reviews.index');

/** Middleware Admin */
Route::group(['middleware'=>'admin'], function()
{
    /** Movies */
    Route::post('/movies', [MovieController::class, 'store'])->name('movies.store');
    Route::get('/movies/{movie}/edit', [MovieController::class, 'edit'])->name('movies.edit');
    Route::get('/movies/create', [MovieController::class, 'create'])->name('movies.create');
    Route::put('/movies/{movie}', [MovieController::class, 'update'])->name('movies.update');
    Route::delete('/movies/{movie}', [MovieController::class, 'destroy'])->name('movies.delete');

    /** Celebs */
    Route::post('/celebs', [CelebController::class, 'store'])->name('celebs.store');
    Route::get('/celebs/{celeb}/edit', [CelebController::class, 'edit'])->name('celebs.edit');
    Route::get('/celebs/create', [CelebController::class, 'create'])->name('celebs.create');
    Route::put('/celebs/{celeb}', [CelebController::class, 'update']);
    Route::delete('/celebs/{celeb}', [CelebController::class, 'destroy']);
});

/** Middleware Auth */
Route::group(['middleware'=> 'auth'], function()
{
    /** Reviews */
    Route::post('/reviews', [ReviewController::class, 'store'])->name('reviews.store');
    Route::get('/reviews/{review}/edit', [ReviewController::class, 'edit'])->name('reviews.edit');
    Route::get('/reviews/create/{movie}', [ReviewController::class, 'create'])->name('reviews.create');
    Route::put('/reviews/{review}', [ReviewController::class, 'update'])->name('reviews.update');
    Route::delete('/reviews/{review}', [ReviewController::class, 'destroy'])->name('reviews.delete');
});


Route::get('/celebs/{celeb}', [CelebController::class, 'show'])->name('celebs.show');
Route::get('/movies/{movie}', [MovieController::class, 'show'])->name('movies.show');
Route::get('/reviews/{review}', [ReviewController::class, 'show'])->name('reviews.show');
