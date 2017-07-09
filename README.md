# laravel-zipbomb

Enable zip bomb defense of your app

## Installation

You can install the package via composer:

``` bash
$ composer require adrianmejias/laravel-zipbomb
```

Start by registering the package's the service provider:

```php
// config/app.php (L5)

'providers' => [
  // ...
  'AdrianMejias\ZipBomb\ZipBombServiceProvider',
],
```

Next, publish the config file.

``` bash
$ php artisan vendor:publish --provider="AdrianMejias\ZipBomb\ZipBombServiceProvider" --tag="config"
```

Finally, register the middleware:

``` php
// app/Http/Kernel.php

protected $middleware = [
    // ...
    \AdrianMejias\ZipBomb\ZipBombMiddleware::class,
];
```

## Changelog

Please see [CHANGELOG](CHANGELOG.md) for more information what has changed recently.

## Testing

``` bash
$ composer test
```

## Contributing

Please see [CONTRIBUTING](CONTRIBUTING.md) for details. Due to nature of this package, there's a fair chance features won't be accepted to keep it light and opinionated.

## Security

If you discover any security related issues, please email adrianmejias@gmail.com instead of using the issue tracker.

## Credits

- [Site Point: How to Defend Your Website with Zip Bomb](https://www.sitepoint.com/how-to-defend-your-website-with-zip-bombs/)
- [All Contributors](../../contributors)

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.