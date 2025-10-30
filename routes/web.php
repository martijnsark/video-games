<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\GameController;
use App\Http\Controllers\UserController;
use App\Http\Middleware\AdminMiddleware;
use Illuminate\Support\Facades\Route;
use App\Models\User;

//guest
Route::get('/', function () {
    return view('home');
}) ->name('home');

Route::get('/about', function () {
    return view('about');
}) ->name('about');




// users (each uses Auth middleware as user sign in proof)
Route::middleware(['auth'])->group(function () {

    // dynamic wishlist route foreach user
    // get all active games
    Route::get('/wishlist/{user}', function (User $user) {
        $games = $user->game_wishlist()->where('is_active', true)->get();
        return view('games.wishlist', compact('user', 'games'));
    })->name('wishlist');

    // route to copy data to wishlist
    Route::post('users/{user}/wishlist/{game}/add', [UserController::class, 'updateWishlist'])
        ->name('wishlist.add');

    // added here to middleware the edit and create
    Route::get('games/create', [GameController::class, 'create'])->name('games.create');
    Route::get('games/{game}/edit', [GameController::class, 'edit'])->name('games.edit');

    // Store, update, destroy
    Route::resource('games', GameController::class)
        ->only(['store', 'update', 'destroy'])
        ->names('games');
});


// admin ( both use my AdminMiddleware to proof their actually admin)
Route::middleware(['auth', AdminMiddleware::class])->group(function () {
    // route to overview page
    Route::get('/games/overview', [GameController::class, 'overview'])
        ->name('games.overview');

    // route to update status of data
    Route::patch('/games/{game}/toggle', [GameController::class, 'toggleStatus'])
        ->name('games.toggle');
});


// has to be here otherwise overview stops loading properly
// Public game route (index)
Route::resource('games', GameController::class)
    ->only(['index'])
    ->names('games');







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
