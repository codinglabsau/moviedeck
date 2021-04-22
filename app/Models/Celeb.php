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

    public function setCelebDobAttribute($value)
    {
        $this->attributes['date_of_birth'] = Carbon::createFromFormat('d/m/Y', $value)->format('Y-m-d');
    }
}
