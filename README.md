<h1 align="center">Laravel Stats</h1>

<p align="center">
<a href="https://styleci.io/repos/104390273">
    <img src="https://styleci.io/repos/104390273/shield?branch=master" alt="">
</a>
<a href="https://travis-ci.org/stefanzweifel/laravel-stats">
    <img src="https://travis-ci.org/stefanzweifel/laravel-stats.svg" alt="">
</a>
<a href="https://coveralls.io/github/stefanzweifel/laravel-stats?branch=master">
    <img src="https://coveralls.io/repos/github/stefanzweifel/laravel-stats/badge.svg?branch=master" alt="">
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

### Installing

The easiest way to install the the pacakge is by using composer.

```shell
composer require wnx/laravel-stats
```

The package will automatically register itself.

If you want to ignore certain folder, files or namespaces you must publish the config file:

```shell
php artisan vendor:publish --provider="Wnx\LaravelStats\StatsServiceProvider"
```

## Usage

After installing you can generate the statistics by running the following Artisan Command

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

## Authors

* **Stefan Zweifel** - *Initial work* - [stefanzweifel](https://github.com/stefanzweifel)

## License

This project is licensed under the MIT License - see the [LICENSE](LICENSE) file for details.
