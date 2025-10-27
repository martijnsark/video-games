<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\GameController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;
use App\Models\User;

//guest
Route::get('/', function () {
    return view('welcome');
});

Route::get('/home', function () {
    return view('home');
}) ->name('home');

Route::get('/about', function () {
    return view('about');
}) ->name('about');

Route::get('/user', function () {
    return view('user');
}) ->name('user');




// users
// dynamic wishlist route foreach user
Route::get('/wishlist/{user}', function  (User $user) {
    // get all active games
    $games = $user->game_wishlist()->where('is_active', true)->get();
    return view('games.wishlist', compact('user','games'));
}) ->name('wishlist');

// route to copy data to wishlist
Route::post('users/{user}/wishlist/{game}/add', [UserController::class, 'updateWishlist'])
    ->name('wishlist.add');






// admin
// route to overview page
Route::get('/games/overview', [GameController::class, 'overview'])
    ->name('games.overview');

// route to update status of data
Route::patch('/games/{game}/toggle', [GameController::class, 'toggleStatus'])
    ->name('games.toggle');


// needs to be here otherwise error on overview
Route::resource('games', GameController::class) ->names('games');

// not mine
Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
