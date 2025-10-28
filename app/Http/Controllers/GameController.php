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
        $query = Game::with('category')
            // only show active games
            ->where('is_active', true);

        // if search returned a value = search value
        if ($request->filled('search')) {
            $search = $request->input('search');

           // build query based on search
            $query->where(function ($q) use ($search) {
                // search based on title, image, description, price, or discount
                $q->where('title', 'like', "%{$search}%")
                    ->orWhere('image', 'like', "%{$search}%")
                    ->orWhere('description', 'like', "%{$search}%")
                    ->orWhere('price', 'like', "%{$search}%")
                    ->orWhere('discount', 'like', "%{$search}%");

                // search based on category
                $q->orWhereHas('category', function ($catQuery) use ($search) {
                    $catQuery->where('name', 'like', "%{$search}%");
                });

                // search based on user
                $q->orWhereHas('user', function ($userQuery) use ($search) {
                    $userQuery->where('name', 'like', "%{$search}%");
                });
            });
        }

        // category search buttons logic
        if ($request->filled('category')) {
            $query->where('category_id', $request->input('category'));
        }

        $games = $query->get();
        // show buttons
        $categories = Category::all();

        return view('games.index', compact('games', 'categories'));
    }




    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //double check user sign-in just in case
        if (!Auth::check()) {
            abort(403, 'You must be logged in to view the create page');
        }

        $categories = Category::all();
        return view('games.create', compact('categories'));
    }




    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //double check user sign-in just in case
        if (!Auth::check()) {
            abort(403, 'You must be logged in to create a game.');
        }


        $validatedData = $request->validate([
            'title' => 'required | string | max:255',
            'image' => 'required | string | max:255',
            'description' => 'required | string | max:255',
            'price' => 'required | numeric',
            'discount' => 'required | numeric',
            'category_id' => 'required | exists:categories,id'
        ]);

        $validatedData['user_id'] = Auth::id();
        $game = game::create($validatedData);

        $game->title = $request->input('title');
        $game->image = $request->input('image');
        $game->description = $request->input('description');
        $game->price = $request->input('price');
        $game->discount = $request->input('discount');

        //foreign id
        //hard coded
        //$game->user_id = 1;
        $game->user_id = Auth::id();
        $game->category_id = $request->input('category_id');

        //save new data
        $game->save();

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
        //double check user sign-in just in case
        if (!Auth::check()) {
            abort(403, 'You must be logged in to view the edit page.');
        }

        $categories = Category::all();
        return view('games.edit', compact('game', 'categories'));
    }




    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Game $game)
    {
        //double check user sign-in just in case
        if (!Auth::check()) {
            abort(403, 'You must be logged in to edit a game.');
        }


        $validatedData = $request->validate([
            'title' => 'required|string|max:255',
            'image' => 'required|string|max:255',
            'description' => 'required|string|max:255',
            'price' => 'required|numeric',
            'discount' => 'required|numeric',
            'category_id' => 'required|exists:categories,id',
        ]);

        $game->update($validatedData);

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

        $game->users()->detach();

        $game->delete();

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



    // anyone can toggle game status for now
    public function toggleStatus(Game $game)
    {
        // Check if user is logged in and is admin
        if (!auth()->check() || !auth()->user()->isAdmin()) {
            abort(403, 'You must be logged in as a admin to use this page.');
        }

        // is game is active make it unactive
        $game->is_active = !$game->is_active;
        //save new data
        $game->save();

        // return to current page
        return redirect()->back();
    }
}
