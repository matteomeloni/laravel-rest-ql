<?php

namespace Matteomeloni\LaravelRestQl\Traits;

use Illuminate\Database\Eloquent\Builder;
use Matteomeloni\LaravelRestQl\Helper;

trait HasSortableScope
{
    /**
     * @param Builder $builder
     * @param mixed|null $sorts
     * @return Builder
     */
    public function scopeSort(Builder $builder, $sorts = null): Builder
    {
        $sorting = Helper::retrieveData($sorts, 'sorts');

        return $builder->when($sorting, function ($query, $sorting) {
            foreach ($sorting as $item) {
                $this->setSortCondition($query, $item);
            }

            return $query;
        });
    }

    /**
     * @param Builder $builder
     * @param $item
     * @return Builder
     */
    private function setSortCondition(Builder $builder, $item): Builder
    {
        $item = (object)$item;
        $item->direction = $item->direction ?? 'asc';

        if (!in_array($item->column, $this->getSearchable())) {
            return $builder;
        }

        return $builder->orderBy($item->column, $item->direction);
    }
}
