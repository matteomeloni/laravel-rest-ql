<?php

namespace Matteomeloni\LaravelRestQl;

use Illuminate\Database\Eloquent\Model;
use Matteomeloni\LaravelRestQl\Traits\HasFilterableScope;
use Matteomeloni\LaravelRestQl\Traits\HasSearchable;
use Matteomeloni\LaravelRestQl\Traits\HasTextSearchScope;

abstract class LaravelRestQl extends Model
{
    use HasFilterableScope,
        HasSearchable,
        HasTextSearchScope;

}
