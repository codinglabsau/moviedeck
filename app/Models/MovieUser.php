<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MovieUser extends Model
{
    use HasFactory;

    protected $fillable = ['user_id', 'movie_id'];

    public $table = "movie_user";
}
