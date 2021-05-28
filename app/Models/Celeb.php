<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Celeb extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'date_of_birth', 'photo'];

    public function movies() {
        return $this->belongsToMany(Movie::class, 'celeb_movie')
            ->withPivot('character_name')
            ->withTimestamps();
    }

    public function setCelebDobAttribute($value)
    {
        $this->attributes['date_of_birth'] = Carbon::createFromFormat('d/m/Y', $value)->format('Y-m-d');
    }
}
