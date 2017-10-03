<?php

namespace Wnx\LaravelStats\Tests\Services;

use Wnx\LaravelStats\Services\StatisticsListService;
use Wnx\LaravelStats\Tests\TestCase;

class StatisticsListServiceTest extends TestCase
{
    /** @test */
    public function it_returns_a_rich_statistics_array()
    {
        $service = resolve(StatisticsListService::class);
        $service->build();

        $data = collect($service->data());

        $controllerSet = $data->where('component', 'Controllers')->first();

        $this->assertEquals(3, $controllerSet['number_of_classes']);
        $this->assertEquals(10, $controllerSet['methods']);
    }

    /** @test */
    public function it_returns_an_array_of_headers()
    {
        $service = resolve(StatisticsListService::class);

        $this->assertEquals([
            'Name',
            'Lines',
            'LOC',
            'Classes',
            'Methods',
            'M/C',
            'LOC/M',
        ], $service->headers());
    }
}
