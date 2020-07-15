<h1 align="center">Laravel Stats</h1>

<p align="center">
<a href="https://packagist.org/packages/wnx/laravel-stats">
    <img src="https://poser.pugx.org/wnx/laravel-stats/v/stable" alt="">
</a>
<a href="https://github.com/stefanzweifel/laravel-stats/actions?query=workflow%3A%22tests%22">
    <img src="https://github.com/stefanzweifel/laravel-stats/workflows/tests/badge.svg" alt="">
</a> 
<a href="https://packagist.org/packages/wnx/laravel-stats">
    <img src="https://poser.pugx.org/wnx/laravel-stats/downloads" alt="">
</a> 
<a href="https://scrutinizer-ci.com/g/stefanzweifel/laravel-stats/?branch=master">
    <img src="https://scrutinizer-ci.com/g/stefanzweifel/laravel-stats/badges/quality-score.png?b=master" alt="">
</a>
<a href="https://plant.treeware.earth/stefanzweifel/laravel-stats">
    <img src="https://img.shields.io/badge/Treeware-%F0%9F%8C%B3-lightgreen" alt="Buy us a tree">
</a>
</p>

<p align="center">
    Get insights about your Laravel or Lumen Project.
</p>

![Screenshot](https://raw.githubusercontent.com/stefanzweifel/laravel-stats/master/screenshot.png)

### Installing

The easiest way to install the package is by using composer. The package requires PHP 7.3, Laravel 7.0 or higher or Lumen 7.0 or higher.  

Due to version conflicts, `stats` can't be installed in Laravel 7 projects which are running with phpunit 8. **Phpunit 9 is required.**

```shell
composer require "wnx/laravel-stats" --dev
```

The package will automatically register itself.

If you're using Lumen you have to manually register the Service Provider in your `bootstrap/app.php` file:

```php
$app->register(\Wnx\LaravelStats\StatsServiceProvider::class);
```

Optionally, you can publish the config file of this package with this command (Laravel only):

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
        base_path('tests'),
    ],

    /*
     * List of files/folders to be excluded from analysis.
     */
    'exclude' => [
        // base_path('app/helpers.php'),
        // base_path('app/Services'),
    ],

    /*
     * List of your custom Classifiers
     */
    'custom_component_classifier' => [
        // \App\Classifiers\CustomerExportClassifier::class
    ],

    /*
     * The Strategy used to reject Classes from the project statistics.
     *
     * By default all Classes located in
     * the vendor directory are being rejected and don't
     * count to the statistics.
     *
     * The package ships with 2 strategies:
     * - \Wnx\LaravelStats\RejectionStrategies\RejectVendorClasses::class
     * - \Wnx\LaravelStats\RejectionStrategies\RejectInternalClasses::class
     *
     * If none of the default strategies fit for your usecase, you can
     * write your own class which implements the RejectionStrategy Contract.
     */
    'rejection_strategy' => \Wnx\LaravelStats\RejectionStrategies\RejectVendorClasses::class,

    /*
     * Namespaces which should be ignored.
     * Laravel Stats uses the `Str::startsWith()`class to
     * check if a Namespace should be ignored.
     *
     * You can use `Illuminate` to ignore the entire `Illuminate`-namespace
     * or `Illuminate\Support` to ignore a subset of the namespace.
     */
    'ignored_namespaces' => [
        'Wnx\LaravelStats',
        'Illuminate',
        'Symfony',
    ],

];

```


## Usage

After installing you can generate the statistics by running the following Artisan Command.

```shell
php artisan stats
```

The statistics are also available as JSON.

```shell
php artisan stats --json
```

If you want a more detailed report and see which classes have been grouped into which component, you can use the `--verbose`-option.

```
php artisan stats --verbose
```

The verbose option is also available for the JSON format.

```
php artisan stats --json --verbose
```



## How does this package detect certain Laravel Components?

The package scans the files defined in the `paths`-array in the configuration file. It then applies [Classifiers](https://github.com/stefanzweifel/laravel-stats/tree/master/src/Classifiers) to those classes to determine which Laravel Component the class represents.

| Component | Classification |
|:--|:--|
| Controller | Must be registered with a Route |
| Model | Must extend `Illuminate\Database\Eloquent\Model` |
| Command | Must extend `Illuminate\Console\Command` |
| Rule | Must extend `Illuminate\Contracts\Validation\Rule` |
| Policy | The Policy must be registered in your `AuthServiceProvider` |
| Middleware | The Middleware must be registered in your Http-Kernel  |
| Event | Must use `Illuminate\Foundation\Events\Dispatchable`-Trait |
| Event Listener | Must be registered for an Event in `EventServiceProvider` |
| Mail | Must extend `Illuminate\Mail\Mailable` |
| Notification | Must extend `Illuminate\Notifications\Notification` |
| Nova Action | Must extend `Laravel\Nova\Actions\Action` |
| Nova Dashboard | Must extend `Laravel\Nova\Dashboard` |
| Nova Filter | Must extend `Laravel\Nova\Filters\Filter` |
| Nova Lens | Must extend `Laravel\Nova\Lenses\Lens` |
| Nova Resource | Must extend `Laravel\Nova\Resource` |
| Job | Must use `Illuminate\Foundation\Bus\Dispatchable`-Trait |
| Migration | Must extend `Illuminate\Database\Migrations\Migration` |
| Request | Must extend `Illuminate\Foundation\Http\FormRequest` |
| Resource | Must extend `Illuminate\Http\Resources\Json\JsonResource` or `Illuminate\Http\Resources\Json\ResourceCollection` |
| Seeder | Must extend `Illuminate\Database\Seeder` |
| ServiceProvider | Must extend `Illuminate\Support\ServiceProvider` |
| Blade Components | Must extend `Illuminate\View\Component` |
| Custom Casts | Must implement `Illuminate\Contracts\Database\Eloquent\CastsAttributes` or `Illuminate\Contracts\Database\Eloquent\CastsInboundAttributes` |
| Dusk Tests | Must extend `Laravel\Dusk\TestCase` |
| BrowserKit Test | Must extend `Laravel\BrowserKitTesting\TestCase` |
| PHPUnit Test | Must extend `PHPUnit\Framework\TestCase` |

## Create your own Classifiers

If your application has it's own components you would like to see in `laravel-stats` you can create your own "Classifiers".
Create your own Classifiers by implementing the [`Classifier`](https://github.com/stefanzweifel/laravel-stats/blob/master/src/Contracts/Classifier.php)-contract and adding the class to the `stats.custom_component_classifier` config array.

For example:

```php
// app/Classifiers/RepositoryClassifier.php
<?php

namespace App\Classifiers;

use Wnx\LaravelStats\ReflectionClass;
use Wnx\LaravelStats\Contracts\Classifier;

class RepositoryClassifier implements Classifier
{
    public function name(): string
    {
        return 'Repositories';
    }

    public function satisfies(ReflectionClass $class): bool
    {
        return $class->isSubclassOf(\App\Repositories\BaseRepository::class);
    }

    public function countsTowardsApplicationCode(): bool
    {
        return true;
    }

    public function countsTowardsTests(): bool
    {
        return false;
    }
}
```

```php
// config/stats.php
<?php
    ...
    'custom_component_classifier' => [
        \App\Classifiers\RepositoryClassifier::class
    ],
    ...
```

## Share Metrics with the Laravel Community
> TODO: Intro to what --share does and where to find charts


You can share your projects statistic by using the `--share` option. 

```shell
php artisan stats --share
```

### Share statistic through CI

If you would like to share your project statistic in an environment where you don't have access to a running shell, you can use the `--no-interaction` and `--name`-options.

Use the following command in your CI script to share your project statistic automatically. Update `org/repo` with the name of your application (eg. `stefanzweifel/`).

```shell
php artisan stats --share --no-interaction --name=org/repo
```

If you're using GitHub Actions you can use the following Workflow template to share data once a week.
> TODO: Add GitHub Actions link here.

### See Request Data shared with the community

> TODO: Describe how to use the `--dry-option`.

## Treeware

You're free to use this package, but if it makes it to your production environment you are required to buy the world a tree.

It’s now common knowledge that one of the best tools to tackle the climate crisis and keep our temperatures from rising above 1.5C is to <a href="https://www.bbc.co.uk/news/science-environment-48870920">plant trees</a>. If you support this package and contribute to the Treeware forest you’ll be creating employment for local families and restoring wildlife habitats.

You can buy trees here [offset.earth/treeware](https://plant.treeware.earth/stefanzweifel/laravel-stats)

Read more about Treeware at [treeware.earth](http://treeware.earth)


## Running the tests

The package has tests written in phpunit. You can run them with the following command.

```shell
./vendor/bin/phpunit
```

## Running the command in a local test project

If you're working on the package locally and want to just run the command in a demo project you can use the [composer path-repository format](https://getcomposer.org/doc/05-repositories.md#path).
Add the following snippet to the `composer.json` in your demo project.

```json
{
    "repositories": [
        {
            "type": "path",
            "url": "/path/to/laravel-stats/",
            "options": {
                "symlink": true
            }
        }
    ],
}
```

And "install" the package with `composer require wnx/laravel-stats`. The package should now be symlinked in your demo project.

## Versioning

We use [SemVer](http://semver.org/) for versioning. For the versions available, see the [tags on this repository](https://github.com/stefanzweifel/laravel-stats/tags).

## Credits

* [Stefan Zweifel](https://github.com/stefanzweifel)
* [Jerguš Lejko](https://github.com/jerguslejko)
* [All Contributors](https://github.com/stefanzweifel/laravel-stats/graphs/contributors)

## License

This project is licensed under the MIT License - see the [LICENSE](LICENSE) file for details.
