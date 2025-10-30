<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    // sets a one-to-many relationship where a category can have many games
    public function games() {
        return $this->hasMany(Game::class);
    }

}
