[![Latest Version](https://img.shields.io/github/release/adrianmejias/laravel-zipbomb.svg?style=flat-square)](https://github.com/adrianmejias/laravel-zipbomb/releases)
[![Software License](https://img.shields.io/badge/license-MIT-brightgreen.svg?style=flat-square)](LICENSE.md)
[![Latest Version on Packagist](https://img.shields.io/packagist/v/adrianmejias/laravel-zipbomb.svg?style=flat-square)](https://packagist.org/packages/adrianmejias/laravel-zipbomb)
[![Build Status](https://img.shields.io/travis/adrianmejias/laravel-zipbomb/master.svg?style=flat-square)](https://travis-ci.org/adrianmejias/laravel-zipbomb)
[![StyleCI](https://styleci.io/repos/96650858/shield)](https://styleci.io/repos/96650858)
[![Total Downloads](https://img.shields.io/packagist/dt/adrianmejias/laravel-zipbomb.svg?style=flat-square)](https://packagist.org/packages/adrianmejias/laravel-zipbomb)

Enable zip bomb defense of your app

## !!Experimental Code!!

Not for use in production environment.

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
$ php artisan vendor:publish --provider="AdrianMejias\ZipBomb\ZipBombServiceProvider"
```

A file named `10G.gzip` should be generated in the `storage/app/zipbomb` folder. If this file does not exist after installation. Use the following command at `storage/app/zipbomb`

``` bash
$ dd if=/dev/zero bs=1M count=10240 | gzip > 10G.gzip
```

The following config file will be published in `config/zipbomb.php`

``` php
/**
 * Laravel Zip Bomb Configuration.
 *
 * Check for nikto, sql map or "bad" subfolders which only exist on
 * WordPress.
 */

return [

    /*
     * User-Agents to check against.
     */
    'agents' => [
        'nikto',
        'sqlmap',
    ],

    /*
     * Paths to check against.
     */
    'paths' => [
        'wp-',
        'wordpress',
        'wp/*',
    ],

    /*
     * Path to the zip bomb file.
     */
    'zip_bomb_file' => storage_path('app/zipbomb/10G.gzip'),

];
```

Finally, register the middleware:

``` php
// app/Http/Kernel.php

protected $middleware = [
    // ...
    \AdrianMejias\ZipBomb\Middleware\ZipBomb::class,
];
```

This package also comes with a facade, which provides an easy way to call the the class for whatever reason.

``` php
// config/app.php

'aliases' => [
    // ...
    'ZipBomb' => AdrianMejias\ZipBomb\ZipBombFacade::class,
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