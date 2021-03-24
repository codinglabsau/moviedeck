<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Movie extends Model
{
    use HasFactory;

    public function watchlists() {
        return $this->belongsToMany('App\Watchlist');
    }

    public function reviews() {
        return $this->hasMany('App\Review');
    }

    public function genres() {
        return $this->belongsToMany('App\Genre');
    }

    public function celebs() {
        return $this->belongsToMany('App\Celeb');
    }
}
