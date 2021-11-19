<?php

namespace Matteomeloni\LaravelRestQl\Traits;

use Illuminate\Database\Eloquent\Builder;
use Matteomeloni\LaravelRestQl\Helper;

trait HasSelectableColumnsScope
{
    /**
     * @param Builder $builder
     * @param mixed $columns
     * @return Builder
     */
    public function scopeChooseColumns(Builder $builder, $columns = []): Builder
    {
        $fields = $this->retrieveColumns($columns);

        return $builder->when($fields, function ($query, $fields) {
            return $query->select($fields);
        });
    }

    /**
     * @param $columns
     * @return array
     */
    private function retrieveColumns($columns): array
    {
        $columns = empty($columns)
            ? Helper::getParameter('columns')
            : $columns;

        if (Helper::isBase64($columns)) {
            $columns = base64_decode($columns);
        }

        if (Helper::isJson($columns)) {
            $columns = json_decode($columns);
        }

        return $columns;
    }
}
