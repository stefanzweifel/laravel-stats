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

        $service = app(StatisticsListService::class);

        $data = collect($service->getData());

        $controllerSet = $data->where('component', 'Controllers')->first();

        $this->assertEquals(2, $controllerSet['number_of_classes']);
        $this->assertEquals(10, $controllerSet['methods']);
    }

    /** @test */
    public function it_returns_an_array_of_headers()
    {
        $service = app(StatisticsListService::class);

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
