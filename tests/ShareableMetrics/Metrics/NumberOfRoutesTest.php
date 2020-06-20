<?php declare(strict_types=1);

namespace Wnx\LaravelStats\Tests\ShareableMetrics\Metrics;

use Illuminate\Support\Facades\Route;
use Wnx\LaravelStats\ShareableMetrics\Metrics\NumberOfRoutes;
use Wnx\LaravelStats\Tests\TestCase;

class NumberOfRoutesTest extends TestCase
{
    /** @test */
    public function it_returns_correct_metric_name()
    {
        $project = $this->createProjectFromClasses([]);

        $metric = new NumberOfRoutes($project);

        $this->assertEquals('number_of_routes', $metric->name());
    }

    /** @test */
    public function it_returns_correct_number_of_routes_for_the_project()
    {
        Route::get('users', 'Wnx\LaravelStats\Tests\Stubs\Controllers\UsersController@index');
        Route::get('users/create', 'Wnx\LaravelStats\Tests\Stubs\Controllers\UsersController@create');
        Route::post('users', 'Wnx\LaravelStats\Tests\Stubs\Controllers\UsersController@store');
        Route::get('users/{user}', 'Wnx\LaravelStats\Tests\Stubs\Controllers\UsersController@show');

        $project = $this->createProjectFromClasses([]);

        $metric = new NumberOfRoutes($project);

        $this->assertEquals(4, $metric->value());
    }
}
