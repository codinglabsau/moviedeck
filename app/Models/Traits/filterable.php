<?php

namespace App\Models\Traits;

use Illuminate\Database\Eloquent\Builder;

trait Filterable
{
    public function scopeFilter(Builder $query, $key, $val, $filterType = 'default')
    {
        if (is_array($key)) {
            $keys = collect($key)->filter(function ($key) {
                return $this->canFilter($key);
            });

            foreach ($keys as $idx => $key) {
                $method = $idx === 0 ? 'where' : 'orWhere';
                $query->$method($key, 'like', $this->getFilterType($filterType, $val));
            }

            return $query;
        }

        if ($this->canFilter($key)) {
            return $query->where($key, 'like', $this->getFilterType($filterType, $val));
        }

        return $query;
    }

    public function getFilterType($type, $val)
    {
        switch ($type) {
            case 'startsWith':
                return "{$val}%";

            default:
                return "%{$val}%";
        }
    }

    protected function canFilter($key)
    {
        return isset($this->filterable) && in_array($key, $this->filterable);
    }
}
