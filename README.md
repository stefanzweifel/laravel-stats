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

```shell
composer require "wnx/laravel-stats" --dev
```

The package will automatically register itself.

If you're using Lumen you have to manually register the Service Provider in your `bootstrap/app.php` file:

```php
$app->register(\Wnx\LaravelStats\StatsServiceProvider::class);
```

Optionally, you can publish the config file in your Laravel applications with the following command:

```shell
php artisan vendor:publish --provider="Wnx\LaravelStats\StatsServiceProvider"
```

## Usage

After installing you can generate the statistics by running the following Artisan Command.

```shell
php artisan stats
```
(Make sure you run `php artisan config:clear` before running the above command.)

The statistics are also available as JSON.

```shell
php artisan stats --json
```

If you want a more detailed report and see which classes have been grouped into which component, you can use the `--verbose`-option.

```
php artisan stats --verbose
```

The verbose option is available for the JSON format also.

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
| Database Factory | Must extend `Illuminate\Database\Eloquent\Factory` |
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

You can optionally share your projects statistic by using the `--share` option. 

```shell
php artisan stats --share
```

Your project statistics is shared anonymously with [stats.laravelshift.com](https://stats.laravelshift.com). In regular intervals the dashboard and charts on the site are updated with shared data from other Laravel projects.

To learn more about this feature, please check out PR [#178](https://github.com/stefanzweifel/laravel-stats/pull/178).

### Share statistic through CI

If you would like to share your project statistic in a CI environment you can use the `--no-interaction` and `--name`-options.

Use the following command in your CI script to share your project statistic automatically. (Update `org/repo` with the name of your application (eg. `acme/podcasting-app`))

```shell
php artisan stats --share --no-interaction --name=org/repo
```

If you're code is hosted on GitHub, you can integrate `stats` with [GitHub Actions](https://docs.github.com/en/actions).
Copy the following Workflow to `.github/workflows/laravel-stats.yml`. It will share data when a commit is pushed to the `master` branch. The Action automatically uses your GitHub repository name in the `--name`-option.

```yaml
name: stats

on:
  push:
    branches:
      - master

jobs:
  stats:
    runs-on: ubuntu-latest

    steps:
      - name: Checkout code
        uses: actions/checkout@v2

      - name: Setup PHP
        uses: shivammathur/setup-php@v2
        with:
          php-version: 7.4
          tools: composer:v2

      - name: Install dependencies
        run: composer install --prefer-dist --no-interaction --no-suggest

      - name: Share Stats
        run: php artisan stats --share --name=$GITHUB_REPOSITORY --no-interaction
```

### Inspect Data shared with the Community

If you would like to inspect the payload the command is sending to the API you can use the `--dry-run` and `--payload` options.

```shell
php artisan stats --share  --no-interaction  --name="org/repo" --dry-run --payload
```

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
