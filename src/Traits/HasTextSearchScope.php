<?php

namespace Matteomeloni\LaravelRestQl\Traits;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\DB;
use Matteomeloni\LaravelRestQl\Helper;

trait HasTextSearchScope
{
    /**
     * @param Builder $builder
     * @param string|null $textSearch
     * @return Builder
     */
    public function scopeTextSearch(Builder $builder, ?string $textSearch): Builder
    {
        $textSearch = empty($textSearch)
            ? Helper::getParameter('search')
            : $textSearch;

        return $builder->when($textSearch, function ($query, $textSearch) {
            foreach ($this->getSearchable() as $i => $column) {
                $query = $query->orWhere(DB::raw("lower({$column})"), 'like', '%' . strtolower($textSearch) . '%');
            }

            return $query;
        });
    }
}
