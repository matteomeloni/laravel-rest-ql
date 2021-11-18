<?php

namespace Matteomeloni\LaravelRestQl\Traits;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Arr;

trait HasFilterableScope
{
    /**
     * @param Builder $builder
     * @param mixed $filters
     * @return Builder
     */
    public function scopeFilter(Builder $builder, $filters = []): Builder
    {
        $filters = $this->retrieveFilters($filters);

        return $builder->when($filters, function ($query, $filters) {
            foreach ($filters as $filter) {
                $query = $this->parseFilter($query, $filter);
            }

            return $query;
        });
    }

    /**
     * @param Builder $query
     * @param $filter
     * @return Builder
     */
    private function parseFilter(Builder $query, $filter): Builder
    {
//                if (!in_array($filter->column, $this->getSearchables())) {
//                    continue;
//                }

        if (is_object($filter)) {
            return $this->setQuery($query, $filter);
        }

        return $query->where(function ($subQuery) use ($filter) {
            foreach ($filter as $item) {
                $this->parseFilter($subQuery, $item);
            }
        });
    }

    /**
     * @param Builder $builder
     * @param object $filter
     * @return Builder
     */
    private function setQuery(Builder $builder, object $filter): Builder
    {
        $filter = (object)$filter;
        $filter->boolean = $filter->boolean ?? 'and';

        if (in_array($filter->operator, ['=', '!=', '>', '<', '>=', '<=', 'like', 'notlike'])) {
            $builder->where($filter->column, $filter->operator, $filter->value, $filter->boolean);
        }

        if ($filter->operator === 'in') {
            $builder->whereIn($filter->column, $filter->value, $filter->boolean);
        }

        if ($filter->operator == 'between') {
            $builder->whereBetween($filter->column, $filter->value, $filter->boolean);
        }

        return $builder;
    }

    /**
     * @param $filters
     * @return array|false|string
     */
    private function retrieveFilters($filters)
    {
        $filters = empty($filters)
            ? request()->filters ?? request()->header('filters')
            : $filters;

        if ($this->isBase64($filters)) {
            $filters = base64_decode($filters);
        }

        if ($this->isJson($filters)) {
            $filters = json_decode($filters);
        }

        return $filters;
    }

    /**
     * Check if string is a json.
     *
     * @param $string
     * @return bool
     */
    private function isJson($string): bool
    {
        return is_string($string) &&
            is_array(json_decode($string, true)) &&
            (json_last_error() == JSON_ERROR_NONE);
    }

    /**
     * Check if string is a base64.
     *
     * @param $string
     * @return bool
     */
    private function isBase64($string): bool
    {
        if (!is_string($string)) {
            return false;
        }

        return (bool)preg_match('/^[a-zA-Z0-9\/\r\n+]*={0,2}$/', $string);
    }
}
