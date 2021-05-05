<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Celeb extends Model
{
    use HasFactory;

    public function movies() {
        return $this->belongsToMany(Movie::class, 'celeb_movie')
            ->withPivot('character_name')
            ->withTimestamps();
    }
}
