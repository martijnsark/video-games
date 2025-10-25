<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Game extends Model
{
    protected $fillable = [
        'title',
        'image',
        'description',
        'price',
        'discount',
        'category_id',
        'user_id',
    ];

    // defines a relationship between a game that belongs to a single category
    public function category() {
        return $this->belongsTo(Category::class);
    }

    // defines a relationship between a game that belongs to a single user
    public function user(){
        return $this->belongsTo(User::class);
    }
}
