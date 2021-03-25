<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Genre extends Model
{
    use HasFactory;

    public const GENRE_ACTION = 'Action';
    public const GENRE_ANIME = 'Anime';
    public const GENRE_ADVENTURE = 'Adventure';
    public const GENRE_COMEDY = 'Comedy';
    public const GENRE_CRIME = 'Crime';
    public const GENRE_DRAMA = 'Drama';
    public const GENRE_FANTASY = 'Fantasy';
    public const GENRE_HORROR = 'Horror';
    public const GENRE_MYSTERY = 'Mystery';
    public const GENRE_ROMANCE = 'Romance';
    public const GENRE_THRILLER = 'Thriller';

    public function movies() {
        return $this->belongsToMany(Movie::class, 'genre_movie');
    }
}
