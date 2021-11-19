<?php

namespace Matteomeloni\LaravelRestQl\Traits;

use Illuminate\Support\Facades\Schema;

trait HasSearchable
{
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
