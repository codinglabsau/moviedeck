<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Watchlist extends Model
{
    use HasFactory;

    public function user() {
        return $this->belongsTo('App\User');
    }

    public function movies() {
        return $this->belongsToMany('App\Movie');
    }
}
