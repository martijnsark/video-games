<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use App\Models\Category;
use Illuminate\Http\Request;
use App\Models\Game;

class GameController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        // creating a query and loads categories
        $query = Game::with('category')
            // show only active games
            ->where('is_active', true);

        // search text based searches if search input given
        if ($request->filled('search')) {
            $search = $request->input('search');

            // filter games where any field matches the search
            // uses parameter binding to safely bind the variable and search value with LIKE
            $query->where(function ($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                    ->orWhere('image', 'like', "%{$search}%")
                    ->orWhere('description', 'like', "%{$search}%")
                    ->orWhere('price', 'like', "%{$search}%")
                    ->orWhere('discount', 'like', "%{$search}%");

                // search based on category like search
                $q->orWhereHas('category', function ($catQuery) use ($search) {
                    $catQuery->where('name', 'like', "%{$search}%");
                });

                // search based on user like search
                $q->orWhereHas('user', function ($userQuery) use ($search) {
                    $userQuery->where('name', 'like', "%{$search}%");
                });
            });
        }

        // filter games by selected category (if provided)
        if ($request->filled('category')) {
            $query->where('category_id', $request->input('category'));
        }

        // execute query and get search results
        $games = $query->get();

        // get all categories for category buttons to display in view
        $categories = Category::all();

        // send user to games.index with the games and categories data
        return view('games.index', compact('games', 'categories'));
    }




    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        // double check user sign-in just in case
        if (!Auth::check()) {
            abort(403, 'You must be logged in to view the create page');
        }

        // track number of wishlisted games by current user
        $wishlistedCount = Auth::user()->game_wishlist()->where('is_active', true)->count();

        // if wishlist has less than 3 wishlisted games return errors
        if ($wishlistedCount < 3) {
            return back()->withErrors([
                'error' => 'You need to have wishlisted at least 3 games to create a new one.'
            ]);
        }

        // a variable that contains all categories data
        $categories = Category::all();

        // send user to games.create with the categories data
        return view('games.create', compact('categories'));
    }




    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // double check user sign-in just in case
        if (!Auth::check()) {
            abort(403, 'You must be logged in to create a game.');
        }

        // double-checking if the user really does have 3 wishlisted games
        $wishlistedCount = Auth::user()->game_wishlist()->where('is_active', true)->count();

        // if wishlist has less than 3 wishlisted games return errors
        if ($wishlistedCount < 3) {
            return back()->withErrors([
                'error' => 'You need to have wishlisted at least 3 games to create a new one.'
            ]);
        }

        // set required validations for data
        $validatedData = $request->validate([
            'title' => 'required | string | max:255',
            'image' => 'required | string | max:255',
            'description' => 'required | string | max:255',
            'price' => 'required | numeric',
            'discount' => 'required | numeric',
            'category_id' => 'required | exists:categories,id'
        ]);

        // adding the currently logged-in user's id to the validated data array
        // validates data
        $validatedData['user_id'] = Auth::id();
        // create and save a new game with safety check
        $game = game::create($validatedData);

        // gather requested input from user
        $game->title = $request->input('title');
        $game->image = $request->input('image');
        $game->description = $request->input('description');
        $game->price = $request->input('price');
        $game->discount = $request->input('discount');

        // get foreign id's from the user and category
        //hard coded example
        //$game->user_id = 1;
        $game->user_id = Auth::id();
        $game->category_id = $request->input('category_id');

        // save data into database
        $game->save();

        // return user to games.index
        return redirect()->route ('games.index');
    }




    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }




    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Game $game)
    {
        // double check user sign-in just in case
        if (!Auth::check()) {
            abort(403, 'You must be logged in to view the edit page.');
        }

        // assurance that the edit page can only be visited by the original creator
        if ($game->user_id !== Auth::id()) {
            abort(403, 'You must be the original creator to view this games edit page.');
        }

        // a variable that contains all categories data
        $categories = Category::all();

        // send user to games.edit with game data and all the categories data
        return view('games.edit', compact('game', 'categories'));
    }




    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Game $game)
    {
        // double check user sign-in just in case
        if (!Auth::check()) {
            abort(403, 'You must be logged in to edit a game.');
        }

        // double assurance that update request can only be performed by the original creator
        if ($game->user_id !== Auth::id()) {
            abort(403, 'You must be the original creator to edit this game.');
        }

        // set required validations for data
        $validatedData = $request->validate([
            'title' => 'required|string|max:255',
            'image' => 'required|string|max:255',
            'description' => 'required|string|max:255',
            'price' => 'required|numeric',
            'discount' => 'required|numeric',
            'category_id' => 'required|exists:categories,id',
        ]);

        // update the game with the new validated data
        $game->update($validatedData);

        // return user to games.index
        return redirect()->route('games.index');
    }




    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Game $game)
    {
        //double check user sign-in just in case
        if (!Auth::check()) {
            abort(403, 'You must be logged in to delete a game.');
        }

        // double assurance that DELETE request can only be performed by the original creator
        if ($game->user_id !== Auth::id()) {
            abort(403, 'You must be the original creator to delete this game.');
        }

        // remove users from wishlist
        $game->users()->detach();

        // delete game
        $game->delete();

        // return user to games.index
        return redirect()->route('games.index');
    }




    //handles overview view + overview required data
    public function overview()
    {
        // Check if user is logged in and is admin
        if (!auth()->check() || !auth()->user()->isAdmin()) {
            abort(403, 'You must be logged in as a admin to view this page.');
        }

        // load all games data
        $games = Game::all();

        // load games.overview with games data
        return view('games.overview', compact('games'));

    }



    // admin can toggle game status
    public function toggleStatus(Game $game)
    {
        // Check if user is logged in and is admin
        if (!auth()->check() || !auth()->user()->isAdmin()) {
            abort(403, 'You must be logged in as a admin to use this page.');
        }

        // if game is active make it unactive
        $game->is_active = !$game->is_active;

        //save new data
        $game->save();

        // return to current page
        return redirect()->back();
    }
}
