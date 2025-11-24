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
</p>

<p align="center">
    Get insights about your Laravel Project.
</p>

![Screenshot](https://raw.githubusercontent.com/stefanzweifel/laravel-stats/master/screenshot.png)

### Installing

The easiest way to install the package is by using composer.

```shell
composer require "wnx/laravel-stats" --dev
```

The package will automatically register itself.

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

> **Note**
> If your project is using [Pest PHP](https://pestphp.com) for writing tests, these files will automatically be excluded from the statistics. Due to how "laravel-stats" works internally, Pest PHP tests can't currently be detected. See [#194](https://github.com/stefanzweifel/laravel-stats/discussions/194) for more information.

## How does this package detect certain Laravel Components?

The package scans the files defined in the `paths`-array in the configuration file. It then applies [Classifiers](https://github.com/stefanzweifel/laravel-stats/tree/master/src/Classifiers) to those classes to determine which Laravel Component the class represents.

| Component | Classification |
|:--|:--|
| Livewire Components | Must extend `Livewire\Component` |
| Controller | Must be registered with a Route & does not extend `Livewire\Component` |
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
