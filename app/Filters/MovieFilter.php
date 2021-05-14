<?php

namespace App\Filters;

use Illuminate\Database\Eloquent\Builder;

class MovieFilter extends QueryFilters
{
    public function search($value): Builder
    {
        return $this->builder->where('title', 'like', '%'.$value.'%');
    }
}
