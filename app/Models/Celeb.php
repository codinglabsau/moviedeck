<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Celeb extends Model
{
    use HasFactory;

    /**
     * @var mixed
     */

    public function movies() {
        return $this->belongsToMany(Movie::class, 'celeb_movie')
            ->withPivot('character_name');
    }
}
