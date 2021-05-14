<?php

namespace App\Models\Traits;

use Illuminate\Database\Eloquent\Builder;

trait Filterable
{
    public function scopeFilter(Builder $query, QueryFilters $filters)
    {
        return $filters->apply($query);
    }
}
