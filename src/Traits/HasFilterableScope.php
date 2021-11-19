<?php

namespace Matteomeloni\LaravelRestQl\Traits;

use Illuminate\Database\Eloquent\Builder;
use Matteomeloni\LaravelRestQl\Helper;

trait HasFilterableScope
{
    /**
     * @param Builder $builder
     * @param mixed|null $filters
     * @return Builder
     */
    public function scopeFilter(Builder $builder, $filters = null): Builder
    {
        $filters = Helper::retrieveData($filters, 'filters');

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
        if (is_object($filter)) {
            return $this->setWhereCondition($query, $filter);
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
    private function setWhereCondition(Builder $builder, object $filter): Builder
    {
        $filter = (object)$filter;
        $filter->boolean = $filter->boolean ?? 'and';

        if (!in_array($filter->column, $this->getSearchable())) {
            return $builder;
        }

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
}
