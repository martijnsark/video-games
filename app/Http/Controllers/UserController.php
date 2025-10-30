<?php

namespace App\Http\Controllers;

use App\Models\Game;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    // adds/removes game from wishlist based on if game id is already in users wishlist
    public function updateWishlist(User $user, Game $game)
    {
        //double check user sign-in just in case
        if (!Auth::check()) {
            abort(403, 'You must be logged in to wishlist a game.');
        }

        // assurance that the wishlist page can only be visited by the correct user
        if ($user->id !== Auth::id()) {
            abort(403, 'You must be the correct user to edit this wishlist page.');
        }

        // check if game isn't in wishlist
        if (!$user->game_wishlist()->where('game_id', $game->id)->exists()) {
            // add game to wishlist if it isn't
            $user->game_wishlist()->attach($game->id);
        } else {
            // remove game from wishlist if it is
            $user->game_wishlist()->detach($game->id);
        }

        // return to current page
        return redirect()->back();
    }
}
