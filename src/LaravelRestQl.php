<?php

namespace Matteomeloni\LaravelRestQl;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Schema;
use Matteomeloni\LaravelRestQl\Traits\HasFilterableScope;
use Matteomeloni\LaravelRestQl\Traits\HasTextSearchScope;

abstract class LaravelRestQl extends Model
{
    use HasFilterableScope,
        HasTextSearchScope;

    /**
     * Get the searchable attributes for the model.
     *
     * @return array
     */
    public function getSearchable(): array
    {
        if (!empty($this->getFillable())) {
            return $this->getFillable();
        }

        return array_diff(
            Schema::getColumnListing($this->getTable()),
            $this->getHidden()
        );
    }
}
