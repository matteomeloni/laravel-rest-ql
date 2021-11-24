<?php

namespace Matteomeloni\LaravelRestQl\Tests;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Matteomeloni\LaravelRestQl\LaravelRestQl;
use Matteomeloni\LaravelRestQl\Tests\Factories\BookFactory;

class Book extends LaravelRestQl
{
    use HasFactory;

    protected $table = 'books_tests';

    protected $guarded = [];

    protected $casts = [
        'category_id' => 'integer'
    ];

   public static function factory(...$parameters)
   {
       return new BookFactory(...$parameters);
   }
}
