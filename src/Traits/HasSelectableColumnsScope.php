<?php

namespace Matteomeloni\LaravelRestQl\Traits;

use Illuminate\Database\Eloquent\Builder;
use Matteomeloni\LaravelRestQl\Helper;

trait HasSelectableColumnsScope
{
    /**
     * @param Builder $builder
     * @param mixed|null $columns
     * @return Builder
     */
    public function scopeChooseColumns(Builder $builder, $columns = null): Builder
    {
        $fields = Helper::retrieveData($columns, 'columns');

        return $builder->when($fields, function ($query, $fields) {
            return $query->select($fields);
        });
    }
}
