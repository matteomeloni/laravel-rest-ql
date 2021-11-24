# LaravelRestQl

[![Latest Version on Packagist][ico-version]][link-packagist]
[![Total Downloads][ico-downloads]][link-downloads]
[![MIT Licensed](https://img.shields.io/badge/license-MIT-brightgreen.svg?style=flat-square)](LICENSE)

A simple way, to be able to build a query into a Laravel model, through a http request.

- [Installation](#installation)

- [Usage](#usage)
  
  - [How to build query](#how-to-build-query)
    
    - [Passing an Array](#passing-an-array)
    
    - [Passing Data with HTTP Request](#passing-data-with-http-request)
  
  - [Examples](#examples)
    
    - [Choose columns](#choose-columns)
    
    - [Search string](#search-string)
    
    - [Where conditions](#where-conditions)
    
    - [Ordering](#ordering)

- [Requirements](#requirements)

## Installation

---

Via Composer

```bash
$ composer require matteomeloni/laravel-rest-ql
```

## Usage

---

Extends your model with `Matteomeloni\LaravelRestQl\LaravelRestQl`

```php
<?php

namespace App\Models;

use Matteomeloni\LaravelRestQl\LaravelRestQl;

class Book extends LaravelRestQl
{
    //
}
```

and into the controller you can use `restQl` scope to make a new query

```php
<?php

namespace App\Http\Controllers;

use App\Models\Book;

class BookController extends Controller
{
    public function index()
    {

        $books = Book::restQL()
            ->get();

        return response()->json($books);
    }
}
```

### How to build query

There are three ways to build a query.

#### Passing an array

```php
<?php

namespace App\Http\Controllers;

use App\Models\Book;

class BookController extends Controller
{
    public function index()
    {
        $data = [
            'search' => ''
            'columns' => [],
            'filters' => [],
            'sorts' => []
        ];

        $books = Book::restQL($data)->get();

        return response()->json($books);
    }
}
```

#### Passing data with HTTP Request.

You can pass data with `http url parameters` or `http request header`.

In this case the format is JSON and you can use base64 for encoding data.

```php
<?php

//Route: /api/books?select=[]&filters=[]&sorts=[]&search=''

namespace App\Http\Controllers;

use App\Models\Book;

class BookController extends Controller
{
    public function index()
    {
        $books = Book::restQL()->get();

        return response()->json($books);
    }
}
```

### Examples

#### Choose columns

```
URL: /api/books
Parameter: columns


/api/books?columns=["title", "description"]
```

#### Search string

Searches for the string in all columns of the table or fillable attribute.

```
URL: /api/books
Parameter: search


/api/books?search=laravel
```

#### Where conditions

Avaialable comparison operators: `=` `!=` `<` `<=` `>` `>=` `like` `not like` `in` `between`

```
URL: /api/books
Parameter: filters

/api/books?filters=[{"column":"category_id","operator":"=","value":1}]

/api/books?filters=[{"column":"category_id","operator":"between","value":[1,10]}]

/api/books?filters=[{"column":"category_id","operator":"in","value":[1,3,5]}]

/api/books=filters=[{"column":"category_id","operator":"=","value":1},{"column":"title","operator":"like","value":"PHP"}]
```

It is possible to concatenate two or more conditions with or logic.

```
URL: /api/books
Parameter: filters

/api/books?filters=[{"column":"category_id","operator":"=","value":1},{"column":"category_id","operator":"=","value":3,"boolean":"or"}]
```

Multiple "where" clauses can be grouped in parentheses to achieve logical grouping in the query.

```
URL: /api/books
Parameter: filters

/api/books?filters=[{"column":"title","operator":"like","value":"PHP"},[{"column":"category_id","operator":"=","value":1},{"column":"category_id","operator":"=","value":3,"boolean":"or"}]]
```

#### Ordering

```
URL: /api/books
Parameter: sorts

/api/books?sorts=[{"column":"title"}]

/api/books?sorts=[{"column":"title", "direction":"desc"}]

/api/books?sorts=[{"column":"title"},{"column":"category_id","direction":"desc"}]
```

## Requirements

- `php 7.4 or later`

- `Laravel 7 or later`

## Testing

```bash
$ composer test
```

## Change log

Please see the [changelog][link-changelog] for more information on what has changed recently.

## Testing

```bash
$ composer test
```

## Contributing

Please see [contributing.md][link-contributors] for details and a todolist.

## Security

If you discover any security related issues, please email matteomelonig@gmail.com instead of using the issue tracker.

## Credits

- [Matteo Meloni][link-author]
- [All Contributors][link-contributors]

## License

MIT. Please see the [license File][link-license] for more information.

[ico-version]: https://img.shields.io/packagist/v/matteomeloni/laravel-rest-ql.svg?style=flat-square
[ico-downloads]: https://img.shields.io/packagist/dt/matteomeloni/laravel-rest-ql.svg?style=flat-square
[link-packagist]: https://packagist.org/packages/matteomeloni/laravel-rest-ql
[link-downloads]: https://packagist.org/packages/matteomeloni/laravel-rest-ql
[link-author]: https://github.com/matteomeloni
[link-contributors]: CONTRIBUTING.md
[link-changelog]: CHANGELOG.md
[link-license]: LICENSE.md
