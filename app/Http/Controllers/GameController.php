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
    public function index()
    {
        $games = Game::with('category', 'user')->get();
        return view('games.index', compact('games'));
    }
    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $categories = Category::all();
        return view('games.create', compact('categories'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //double check user sign-in
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

        $game = new game();

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
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
