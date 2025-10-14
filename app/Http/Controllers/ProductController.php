<?php

namespace App\Http\Controllers;

class ProductController
{
    public function index()
    {
        $game = new Game();
        $game->title = 'Monster Hunter World';
        $game->image = 'image';
        $game->description = 'this is text about a game';
        $game->price = 50;
        $game->discount = 10;
    }
}
