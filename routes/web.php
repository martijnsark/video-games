<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\GameController;
use Illuminate\Support\Facades\Route;
use App\Models\User;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/home', function () {
    $users = User::all();
    return view('home', ['users' => $users]);
}) ->name('home');

Route::get('/about', function () {
    return view('about');
}) ->name('about');

Route::get('/contact', function () {
    return view('contact');
}) ->name('contact');

Route::get('/game', function () {
    return view('game');
}) ->name('game');


Route::resource('games', GameController::class);



Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
