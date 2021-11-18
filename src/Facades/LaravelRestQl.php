<?php

namespace Matteomeloni\LaravelRestQl\Facades;

use Illuminate\Support\Facades\Facade;

class LaravelRestQl extends Facade
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor(): string
    {
        return 'laravel-rest-ql';
    }
}
