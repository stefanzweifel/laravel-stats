<?php

namespace Wnx\LaravelStats\Tests\Services;

use Wnx\LaravelStats\Tests\TestCase;
use Illuminate\Support\Facades\Route;
use Wnx\LaravelStats\Services\StatisticsListService;

class StatisticsListServiceTest extends TestCase
{
    /** @test */
    public function it_returns_a_rich_statistics_array()
    {
        Route::get('projects', 'Wnx\LaravelStats\Tests\Stubs\Controllers\ProjectsController@index');
        Route::get('users', 'Wnx\LaravelStats\Tests\Stubs\Controllers\UsersController@index');

        $service = resolve(StatisticsListService::class);

        $data = $service->getData();

        $controllerSet = $data->where('component', 'Controllers')->first();

        $this->assertEquals(2, $controllerSet['number_of_classes']);
        $this->assertEquals(10, $controllerSet['methods']);
    }

    /** @test */
    public function it_does_not_throw_exception_if_route_closure_is_defined()
    {
        Route::get('foo', function () {
            return [];
        });

        $service = resolve(StatisticsListService::class);

        $data = collect($service->getData());

        $controllerSet = $data->where('component', 'Models')->first();

        $this->assertEquals(1, $controllerSet['number_of_classes']);
    }

    /** @test */
    public function it_returns_an_array_of_headers()
    {
        $service = resolve(StatisticsListService::class);

        $this->assertEquals([
            'Name',
            'Classes',
            'Methods',
            'Methods/Class',
            'Lines',
            'LoC',
            'LoC/Method',
        ], $service->getHeaders());
    }
}
