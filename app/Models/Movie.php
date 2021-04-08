<?php

namespace App\Models;

use Carbon\CarbonInterval;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Movie extends Model
{
    use HasFactory;

    public function watchlists() {
        return $this->belongsToMany(Watchlist::class, 'movie_watchlist');
    }

    public function reviews() {
        return $this->hasMany(Review::class);
    }

    public function genres() {
        return $this->belongsToMany(Genre::class, 'genre_movie');
    }

    public function celebs() {
        return $this->belongsToMany(Celeb::class, 'celeb_movie')
            ->withPivot('character_name');
    }

    public function getDurationAttribute() {
        return CarbonInterval::minutes($this->attributes['duration'])->cascade()->forHumans(['short' => true]);
    }
}
