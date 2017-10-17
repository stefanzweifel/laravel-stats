<h1 align="center">Laravel Stats</h1>

<p align="center">
<a href="https://styleci.io/repos/104390273">
    <img src="https://styleci.io/repos/104390273/shield?branch=master" alt="">
</a>
<a href="https://travis-ci.org/stefanzweifel/laravel-stats">
    <img src="https://travis-ci.org/stefanzweifel/laravel-stats.svg" alt="">
</a>
<a href="https://packagist.org/packages/wnx/laravel-stats">
    <img src="https://poser.pugx.org/wnx/laravel-stats/v/stable" alt="">
</a>
<a href="https://packagist.org/packages/wnx/laravel-stats">
    <img src="https://poser.pugx.org/wnx/laravel-stats/downloads" alt="">
</a>
<a href="https://packagist.org/packages/wnx/laravel-stats">
    <img src="https://poser.pugx.org/wnx/laravel-stats/license" alt="">
</a>
</p>

Get insights about your Laravel Project. (Inspired by [`rake stats`](https://robots.thoughtbot.com/simple-test-metrics-in-your-rails-app-and-what-they))

![Screenshot](https://raw.githubusercontent.com/stefanzweifel/laravel-stats/master/screenshot.png)

### Installing

The easiest way to install the the package is by using composer (The package is currently in BETA).
The package requires PHP 7.0 and Laravel 5.5 or higher.

```shell
composer require "wnx/laravel-stats:1.0.0-beta-2"
```

The package will automatically register itself.

Optionally, you can publish the config file of this package with this command:

```shell
php artisan vendor:publish --provider="Wnx\LaravelStats\StatsServiceProvider"
```

The following config file will be published in `config/stats.php`

```php
<?php

return [

    /*
     * List of folders to be analyzed.
     */
    'paths' => [
        base_path('app'),
        base_path('database'),
    ],

    /*
     * List of files/folders to be excluded from analysis.
     */
    'exclude' => [
        // base_path('app/helpers.php'),
        // base_path('app/Services'),
    ],

];

```


## Usage

After installing you can generate the statistics by running the following Artisan Command.

```shell
php artisan stats
```

## Running the tests

The package has tests written in phpunit. You can run them with the following command.

```shell
./vendor/bin/phpunit
```

## Versioning

We use [SemVer](http://semver.org/) for versioning. For the versions available, see the [tags on this repository](https://github.com/stefanzweifel/laravel-stats/tags).

## Credits

* [Stefan Zweifel](https://github.com/stefanzweifel)
* [Jerguš Lejko](https://github.com/jerguslejko)
* [All Contributors](https://github.com/stefanzweifel/laravel-stats/graphs/contributors)

## License

This project is licensed under the MIT License - see the [LICENSE](LICENSE) file for details.
