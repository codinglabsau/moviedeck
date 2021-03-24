<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Review extends Model
{
    use HasFactory;

    public function user() {
        return $this->belongsTo('App\User');
    }

    public function movie() {
        return $this->hasOne('App\Movie');
    }
}
