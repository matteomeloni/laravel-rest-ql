# LaravelRestQl

[![Latest Version on Packagist][ico-version]][link-packagist]
[![Total Downloads][ico-downloads]][link-downloads]
[![MIT Licensed](https://img.shields.io/badge/license-MIT-brightgreen.svg?style=flat-square)](LICENSE)

A simple way, to be able to build a query into a Laravel model, through a http request.

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
